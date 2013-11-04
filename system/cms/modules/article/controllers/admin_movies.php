<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Page Layouts controller for the Pages module
 *
 * @author		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\article\Controllers
 */
class Admin_Movies extends Admin_Controller {

    /**
     * The current active section
     * @access protected
     * @var int
     */
    protected $section = 'movies';

    /**
     * Array that contains the validation rules
     * @access protected
     * @var array
     */
    protected $validation_rules = array(
        array(
            'field' => 'title',
            'label' => 'lang:mov_title_label',
            'rules' => 'trim'
        ),
        array(
            'field' => 'link',
            'label' => 'lang:mov_link_label',
            'rules' => 'trim|required|callback__check_id'
        ),
    );

    /**
     * The constructor
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();

        $this->load->model('article_movies_m');
        $this->lang->load('movies');
        $this->lang->load('categories');
        $this->lang->load('article');

        // Load the validation library along with the rules
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->validation_rules);
    }

    /**
     * Index method, lists all movies
     * @access public
     * @return void
     */
    public function index() {
        $this->pyrocache->delete_all('modules_m');

        // Create pagination links
        $total_rows = $this->article_movies_m->count_all();
        $pagination = create_pagination('admin/article/movies/index', $total_rows, NULL, 5);

        // Using this data, get the relevant results
        $movies = $this->article_movies_m->order_by('title')->limit($pagination['limit'])->get_all();

        $this->template
                ->title($this->module_details['name'], lang('mov_list_title'))
                ->set('movies', $movies)
                ->set('pagination', $pagination)
                ->build('admin/movies/index');
    }

    function _check_id($movie_id = '') {
        if (preg_match("[a-zA-Z0-9]", $movie_id)) {
            return true;
        }

        if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $movie_id)) {
            $v = null;
            parse_str(parse_url($movie_id, PHP_URL_QUERY));
            if ($v != null || $v != '')
                return true;
            else
                $this->form_validation->set_message('_check_id', sprintf(lang('mov_invalid_url'), lang('mov_link_label')));
            return false;
        }
        return true;
    }

    /**
     * Create method, creates a new movegory
     *
     * @return void
     */
    public function create() {
        // Validate the data
        if ($this->form_validation->run()) {
            if ($id = $this->article_movies_m->insert($_POST)) {
                // Fire an event. A new article movie has been created.
                Events::trigger('article_movie_created', $id);

                $this->session->set_flashdata('success', sprintf(lang('mov_add_success'), $this->input->post('title')));
            } else {
                $this->session->set_flashdata('error', lang('mov_add_error'));
            }

            redirect('admin/article/movies');
        }

        // Loop through each validation rule
        foreach ($this->validation_rules as $rule) {
            $movie->{$rule['field']} = set_value($rule['field']);
        }

        $this->template
                ->title($this->module_details['name'], lang('mov_create_title'))
                ->set('movie', $movie)
                ->build('admin/movies/form');
    }

    /**
     * Edit method, edits an existing movie
     * @access public
     * @param int id The ID of the movie to edit
     * @return void
     */
    public function edit($id = 0) {
        // Get the movie
        $movie = $this->article_movies_m->get($id);

        // ID specified?
        $movie or redirect('admin/article/movies/index');

        // Validate the results
        if ($this->form_validation->run()) {
            $this->article_movies_m->update($id, $_POST) ? $this->session->set_flashdata('success', sprintf(lang('mov_edit_success'), $this->input->post('title'))) : $this->session->set_flashdata('error', lang('mov_edit_error'));

            // Fire an event. A article movie is being updated.
            Events::trigger('article_movie_updated', $id);

            redirect('admin/article/movies/index');
        }

        // Loop through each rule
        foreach ($this->validation_rules as $rule) {
            if ($this->input->post($rule['field']) !== FALSE) {
                $movie->{$rule['field']} = $this->input->post($rule['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], sprintf(lang('mov_edit_title'), $movie->title))
                ->set('movie', $movie)
                ->build('admin/movies/form');
    }

    /**
     * Delete method, deletes an existing movie (obvious isn't it?)
     * @access public
     * @param int id The ID of the movie to edit
     * @return void
     */
    public function delete($id = 0) {
        $id_array = (!empty($id)) ? array($id) : $this->input->post('action_to');

        // Delete multiple
        if (!empty($id_array)) {
            $deleted = 0;
            $to_delete = 0;
            $deleted_ids = array();
            foreach ($id_array as $id) {
                if ($this->article_movies_m->delete($id)) {
                    $deleted++;
                    $deleted_ids[] = $id;
                } else {
                    $this->session->set_flashdata('error', sprintf(lang('mov_mass_delete_error'), $id));
                }
                $to_delete++;
            }

            if ($deleted > 0) {
                $this->session->set_flashdata('success', sprintf(lang('mov_mass_delete_success'), $deleted, $to_delete));
            }

            // Fire an event. One or more movies have been deleted.
            Events::trigger('article_movie_deleted', $deleted_ids);
        } else {
            $this->session->set_flashdata('error', lang('mov_no_select_error'));
        }

        redirect('admin/article/movies/index');
    }

    /**
     * Create method, creates a new movie via ajax
     * @access public
     * @return void
     */
    public function create_ajax() {
        // Loop through each validation rule
        foreach ($this->validation_rules as $rule) {
            $movie->{$rule['field']} = set_value($rule['field']);
        }

        $data = array(
            'method' => 'create',
            'movie' => $movie,
        );

        if ($this->form_validation->run()) {
            $id = $this->article_movies_m->insert_ajax($this->input->post());

            if ($id > 0) {
                $message = sprintf(lang('mov_add_success'), $this->input->post('title', TRUE));
            } else {
                $message = lang('mov_add_error');
            }

            return $this->template->build_json(array(
                        'message' => $message,
                        'title' => $this->input->post('title'),
                        'movie_id' => $id,
                        'status' => 'ok'
                    ));
        } else {
            // Render the view
            $form = $this->load->view('admin/movies/form', $data, TRUE);

            if ($errors = validation_errors()) {
                return $this->template->build_json(array(
                            'message' => $errors,
                            'status' => 'error',
                            'form' => $form
                        ));
            }

            echo $form;
        }
    }

}