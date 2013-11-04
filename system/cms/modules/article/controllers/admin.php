<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @author 		PyroCMS Dev Team
 * @package 	PyroCMS\Core\Modules\article\Controllers
 */
class Admin extends Admin_Controller {

    /**
     * The current active section
     *
     * @var string
     */
    protected $section = 'posts';

    /**
     * Array that contains the validation rules
     *
     * @var array
     */
    protected $validation_rules = array(
        array(
            'field' => 'thumb',
            'label' => 'lang:article_thumb_label',
            'rules' => ''
        ),
        array(
            'field' => 'title',
            'label' => 'lang:article_title_label',
            'rules' => 'trim|htmlspecialchars|required|max_length[100]|callback__check_title'
        ),
        array(
            'field' => 'slug',
            'label' => 'lang:article_slug_label',
            'rules' => 'trim|required|alpha_dot_dash|max_length[100]|callback__check_slug'
        ),
        array(
            'field' => 'category_id',
            'label' => 'lang:article_category_label',
            'rules' => 'trim|numeric'
        ),
        array(
            'field' => 'keywords',
            'label' => 'lang:global:keywords',
            'rules' => 'trim'
        ),
        array(
            'field' => 'intro',
            'label' => 'lang:article_intro_label',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'body',
            'label' => 'lang:article_content_label',
            'rules' => 'trim'
        ),
        array(
            'field' => 'type',
            'rules' => 'trim'
        ),
        array(
            'field' => 'status',
            'label' => 'lang:article_status_label',
            'rules' => 'trim|alpha'
        ),
        array(
            'field' => 'created_on',
            'label' => 'lang:article_date_label',
            'rules' => 'trim'
        ),
        array(
            'field' => 'created_on_hour',
            'label' => 'lang:article_created_hour',
            'rules' => 'trim|numeric'
        ),
        array(
            'field' => 'created_on_minute',
            'label' => 'lang:article_created_minute',
            'rules' => 'trim|numeric'
        ),
        array(
            'field' => 'comments_enabled',
            'label' => 'lang:article_comments_enabled_label',
            'rules' => 'trim|numeric'
        )
    );

    /**
     * The constructor
     */
    public function __construct() {
        parent::__construct();

        $this->load->model(array('article_m', 'article_categories_m'));
        $this->lang->load(array('article', 'categories'));

        $this->load->library(array('keywords/keywords', 'form_validation'));

        // Date ranges for select boxes
        $this->template
                ->set('hours', array_combine($hours = range(0, 23), $hours))
                ->set('minutes', array_combine($minutes = range(0, 59), $minutes))
        ;

        $_categories = array();
        if ($categories = $this->article_categories_m->order_by('title')->get_all()) {
            foreach ($categories as $category) {
                $_categories[$category->id] = $category->title;
            }
        }
        $this->template->set('categories', $_categories);
    }

    /**
     * Show all created article posts
     * @access public
     * @return void
     */
    public function index() {
        //set the base/default where clause
        $base_where = array('show_future' => TRUE, 'status' => 'all');

        //add post values to base_where if f_module is posted
        $base_where = $this->input->post('f_category') ? $base_where + array('category' => $this->input->post('f_category')) : $base_where;

        $base_where['status'] = $this->input->post('f_status') ? $this->input->post('f_status') : $base_where['status'];

        $base_where = $this->input->post('f_keywords') ? $base_where + array('keywords' => $this->input->post('f_keywords')) : $base_where;

        // Create pagination links
        $total_rows = $this->article_m->count_by($base_where);
        $pagination = create_pagination('admin/article/index', $total_rows);

        // Using this data, get the relevant results
        $article = $this->article_m->limit($pagination['limit'])->get_many_by($base_where);

        //do we need to unset the layout because the request is ajax?
        $this->input->is_ajax_request() ? $this->template->set_layout(FALSE) : '';

        $this->template
                ->title($this->module_details['name'])
                ->append_js('admin/filter.js')
                ->set('pagination', $pagination)
                ->set('article', $article);

        $this->input->is_ajax_request() ? $this->template->build('admin/tables/posts') : $this->template->build('admin/index');
    }

    /**
     * Create new post
     *
     * @return void
     */
    public function upload_thumb() {
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['encrypt_name'] = 'true';

        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('thumb')) {
            return "";
        } else {
            $data = $this->upload->data();
            return substr($config['upload_path'], 2, strlen($config['upload_path'])) . $data['file_name'];
        }
    }

    public function create() {
        $update_data = new stdClass();
        $this->form_validation->set_rules($this->validation_rules);

        if ($this->input->post('created_on')) {
            $created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
        } else {
            $created_on = now();
        }


        if ($_POST) {

            // They are trying to put this live
            if ($this->input->post('status') == 'live') {
                role_or_die('article', 'put_live');
            }


            if ( ($update_data->thumb = $this->upload_thumb()) == '') {
                $this->session->set_flashdata('error', 'Falha ao realizar upload');
            }
            $update_data->title = $this->input->post('title');
            $update_data->slug = $this->input->post('slug');
            $update_data->category_id = $this->input->post('category_id');
            $update_data->keywords = Keywords::process($this->input->post('keywords'));
            $update_data->intro = $this->input->post('intro');
            $update_data->body = $this->input->post('body');
            $update_data->status = $this->input->post('status');
            $update_data->created_on = $created_on;
            $update_data->comments_enabled = $this->input->post('comments_enabled');
            $update_data->author_id = $this->current_user->id;
            $update_data->type = $this->input->post('type');
            $update_data->parsed = ($this->input->post('type') == 'markdown') ? parse_markdown($this->input->post('body')) : '';
            if ($id = $this->article_m->insert($update_data)) {
                $this->pyrocache->delete_all('article_m');
                $this->session->set_flashdata('success', sprintf($this->lang->line('article_post_add_success'), $this->input->post('title')));

                // They are trying to put this live
                if ($this->input->post('status') == 'live') {
                    // Fire an event, we're posting a new article!
                    Events::trigger('article_article_published', $id);
                }
            } else {

                $this->session->set_flashdata('error', $this->lang->line('article_post_add_error'));
            }

            // Redirect back to the form or main page
            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/article') : redirect('admin/article/edit/' . $id);
        } else {
            // Go through all the known fields and get the post values
            foreach ($this->validation_rules as  $field) {
                $post->{$field['field']} = set_value($field['field']);
            }
            $post->created_on = $created_on;
            // if it's a fresh new article lets show them the advanced editor
            if ($post->type == '')
                $post->type = 'wysiwyg-advanced';
        }

        $this->template
                ->title($this->module_details['name'], lang('article_create_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
                ->append_js('jquery/jquery.tagsinput.js')
                ->append_js('module::article_form.js')
                ->append_css('jquery/jquery.tagsinput.css')
                ->set('post', $post)
                ->build('admin/form');
    }

    /**
     * Edit article post
     *
     * @access public
     * @param int $id the ID of the article post to edit
     * @return void
     */
    public function edit($id = 0) {
        $id OR redirect('admin/article');

        $post = $this->article_m->get($id);
        $post->keywords = Keywords::get_string($post->keywords);

        // If we have a useful date, use it
        if ($this->input->post('created_on')) {
            $created_on = strtotime(sprintf('%s %s:%s', $this->input->post('created_on'), $this->input->post('created_on_hour'), $this->input->post('created_on_minute')));
        } else {
            $created_on = $post->created_on;
        }

        /*   $this->form_validation->set_rules(array_merge($this->validation_rules, array(
          'title' => array(
          'field' => 'title',
          'label' => 'lang:article_title_label',
          'rules' => 'trim|htmlspecialchars|required|max_length[100]|callback__check_title[' . $id . ']'
          ),
          'slug' => array(
          'field' => 'slug',
          'label' => 'lang:article_slug_label',
          'rules' => 'trim|required|alpha_dot_dash|max_length[100]|callback__check_slug[' . $id . ']'
          ),
          )));
         */
         
        if ($_POST) {
	    
            #$this->upload_thumb();
            // They are trying to put this live
            if ($post->status != 'live' and $this->input->post('status') == 'live') {
                role_or_die('article', 'put_live');
            }
            $update_data = array();
            if ( ($filename = $this->upload_thumb()) != '') {
                $update_data['thumb'] = $filename;
            } else {
            	if($post ->thumb != '') {
            		$update_data['thumb'] = $post->thumb;
            	} else {
            		$this->session->set_flashdata('error', 'Falha ao realizar upload');
            	}
            }
            
            $update_data['title'] = $this->input->post('title');
            $update_data['slug'] = $this->input->post('slug');
            $update_data['category_id'] = $this->input->post('category_id');
            $update_data['keywords'] = Keywords::process($this->input->post('keywords'));
            $update_data['intro'] = $this->input->post('intro');
            $update_data['body'] = $this->input->post('body');
            $update_data['status'] = $this->input->post('status');
            $update_data['created_on'] = $created_on;
            $update_data['comments_enabled'] = $this->input->post('comments_enabled');
            $update_data['type'] = $this->input->post('type');
            $update_data['parsed'] = ($this->input->post('type') == 'markdown') ? parse_markdown($this->input->post('body')) : '';
            $update_data['author_id'] = empty($post->display_name) ? $this->current_user->id : $post->author_id;

            if ($this->article_m->update($id ,$update_data)) {
                $this->session->set_flashdata(array('success' => sprintf(lang('article_edit_success'), $this->input->post('title'))));
                // They are trying to put this live
                if ($post->status != 'live' and $this->input->post('status') == 'live') {
                    Events::trigger('article_article_published', $id);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line('article_edit_error'));
            }

            // Redirect back to the form or main page
            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/article') : redirect('admin/article/edit/' . $id);
        }

        // Go through all the known fields and get the post values
        foreach ($this->validation_rules as $key => $field) {
            if (isset($_POST[$field['field']])) {
                $post->$field['field'] = set_value($field['field']);
            }
        }

        $post->created_on = $created_on;

        $this->template
                ->title($this->module_details['name'], sprintf(lang('article_edit_title'), $post->title))
                ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
                ->append_js('jquery/jquery.tagsinput.js')
                ->append_js('module::article_form.js')
                ->append_css('jquery/jquery.tagsinput.css')
                ->set('post', $post)
                ->build('admin/form');
    }

    /**
     * Preview article post
     * @access public
     * @param int $id the ID of the article post to preview
     * @return void
     */
    public function preview($id = 0) {
        $post = $this->article_m->get($id);

        $this->template
                ->set_layout('modal', 'admin')
                ->set('post', $post)
                ->build('admin/preview');
    }

    /**
     * Helper method to determine what to do with selected items from form post
     * @access public
     * @return void
     */
    public function action() {
        switch ($this->input->post('btnAction')) {
            case 'publish':
                $this->publish();
                break;

            case 'delete':
                $this->delete();
                break;

            default:
                redirect('admin/article');
                break;
        }
    }

    /**
     * Publish article post
     * @access public
     * @param int $id the ID of the article post to make public
     * @return void
     */
    public function publish($id = 0) {
        role_or_die('article', 'put_live');

        // Publish one
        $ids = ($id) ? array($id) : $this->input->post('action_to');

        if (!empty($ids)) {
            // Go through the array of slugs to publish
            $post_titles = array();
            foreach ($ids as $id) {
                // Get the current page so we can grab the id too
                if ($post = $this->article_m->get($id)) {
                    $this->article_m->publish($id);

                    // Wipe cache for this model, the content has changed
                    $this->pyrocache->delete('article_m');
                    $post_titles[] = $post->title;
                }
            }
        }

        // Some posts have been published
        if (!empty($post_titles)) {
            // Only publishing one post
            if (count($post_titles) == 1) {
                $this->session->set_flashdata('success', sprintf($this->lang->line('article_publish_success'), $post_titles[0]));
            }
            // Publishing multiple posts
            else {
                $this->session->set_flashdata('success', sprintf($this->lang->line('article_mass_publish_success'), implode('", "', $post_titles)));
            }
        }
        // For some reason, none of them were published
        else {
            $this->session->set_flashdata('notice', $this->lang->line('article_publish_error'));
        }

        redirect('admin/article');
    }

    /**
     * Delete article post
     * @access public
     * @param int $id the ID of the article post to delete
     * @return void
     */
    public function delete($id = 0) {
        $this->load->model('comments/comments_m');

        role_or_die('article', 'delete_live');

        // Delete one
        $ids = ($id) ? array($id) : $this->input->post('action_to');

        // Go through the array of slugs to delete
        if (!empty($ids)) {
            $post_titles = array();
            $deleted_ids = array();
            foreach ($ids as $id) {
                // Get the current page so we can grab the id too
                if ($post = $this->article_m->get($id)) {
                    if ($this->article_m->delete($id)) {
                        $this->comments_m->where('module', 'article')->delete_by('module_id', $id);

                        // Wipe cache for this model, the content has changed
                        $this->pyrocache->delete('article_m');
                        $post_titles[] = $post->title;
                        $deleted_ids[] = $id;
                    }
                }
            }

            // Fire an event. We've deleted one or more article posts.
            Events::trigger('article_article_deleted', $deleted_ids);
        }

        // Some pages have been deleted
        if (!empty($post_titles)) {
            // Only deleting one page
            if (count($post_titles) == 1) {
                $this->session->set_flashdata('success', sprintf($this->lang->line('article_delete_success'), $post_titles[0]));
            }
            // Deleting multiple pages
            else {
                $this->session->set_flashdata('success', sprintf($this->lang->line('article_mass_delete_success'), implode('", "', $post_titles)));
            }
        }
        // For some reason, none of them were deleted
        else {
            $this->session->set_flashdata('notice', lang('article_delete_error'));
        }

        redirect('admin/article');
    }

    /**
     * Callback method that checks the title of an post
     * @access public
     * @param string title The Title to check
     * @return bool
     */
    public function _check_title($title, $id = null) {
        $this->form_validation->set_message('_check_title', sprintf(lang('article_already_exist_error'), lang('article_title_label')));
        return $this->article_m->check_exists('title', $title, $id);
    }

    /**
     * Callback method that checks the slug of an post
     * @access public
     * @param string slug The Slug to check
     * @return bool
     */
    public function _check_slug($slug, $id = null) {
        $this->form_validation->set_message('_check_slug', sprintf(lang('article_already_exist_error'), lang('article_slug_label')));
        return $this->article_m->check_exists('slug', $slug, $id);
    }

    /**
     * method to fetch filtered results for article list
     * @access public
     * @return void
     */
    public function ajax_filter() {
        $category = $this->input->post('f_category');
        $status = $this->input->post('f_status');
        $keywords = $this->input->post('f_keywords');

        $post_data = array();

        if ($status == 'live' OR $status == 'draft') {
            $post_data['status'] = $status;
        }

        if ($category != 0) {
            $post_data['category_id'] = $category;
        }

        //keywords, lets explode them out if they exist
        if ($keywords) {
            $post_data['keywords'] = $keywords;
        }
        $results = $this->article_m->search($post_data);

        //set the layout to false and load the view
        $this->template
                ->set_layout(FALSE)
                ->set('article', $results)
                ->build('admin/tables/posts');
    }

}
