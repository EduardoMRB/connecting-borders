<section class="title">
	<?php if ($this->controller == 'admin_courses' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('courses:edit_title'), $course->name);?></h4>
	<?php else: ?>
	<h4><?php echo lang('courses:create_title');?></h4>
	<?php $course->beginning = date("d-m-Y", now());?>
	<?php endif; ?>
</section>

<section class="item">
<?php echo form_open($this->uri->uri_string(), 'class="crud" id="courses"'); ?>

<div class="tabs">

	<ul class="tab-menu">
		<li><a href="#courses-content-tab"><span><?php echo lang('courses:course'); ?></span></a></li>
		<li><a href="#courses-periods-tab"><span><?php echo lang('courses:periods'); ?></span></a></li>
	</ul>

	<div class="form_inputs" id="courses-content-tab">
	<fieldset>
	<ul>
		<li>
			<label for="name"><?php echo lang('courses:name');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('name', $course->name);?> </div>
		</li>
		<li>
			<label for="language_id"><?php echo lang('courses:language'); ?> <span>*</span></label>
			<div class="input">
			<?php echo form_dropdown('language_id',array(lang('courses:select-option')) + $language_options, @$course->language_id); ?>
			</div>
		</li>
		<li>
			<label for="hourly_load"><?php echo lang('courses:hourly_load');?></label>
			<div class="input"><?php echo  form_input('hourly_load', @$course->hourly_load); ?></div>
		</li>
		<li class="date-meta">
			<label><?php echo lang('courses:beginning'); ?></label>
			
			<div class="input datetime_input">
			<?php echo form_input('beginning',  @$course->beginning, 'id="datepicker"'); ?> &nbsp;
			</div>
		</li>
		<li class="even editor">
			<label for="body"><?php echo lang('courses:content'); ?></label>

			<div class="input">
				<?php echo form_dropdown('type', array(
					'html' => 'html',
					'markdown' => 'markdown',
					'wysiwyg-simple' => 'wysiwyg-simple',
					'wysiwyg-advanced' => 'wysiwyg-advanced',
				), $course->type); ?>
			</div>
				
			<br style="clear:both"/>
				
			<?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => @$course->body, 'rows' => 30, 'class' => $course->type)); ?>
				
		</li>
	</ul>
	</fieldset>
	</div>

	<div class="form_inputs" id="courses-periods-tab">
	<fieldset>
		<ul>
			<li>
			<?php 
				echo $this->load->view('admin/periods/index');
				echo form_submit('period', lang('courses:add_period'));
			?>
			</li>
		</ul>
	</fieldset>
	</div>
	
</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?></div>

<?php echo form_close(); ?>
</section>
<script type="text/javascript">
/*
 * MultiDatesPicker v1.6.1
 * http://multidatespickr.sourceforge.net/
 * 
 * Copyright 2011, Luca Lauretta
 * Dual licensed under the MIT or GPL version 2 licenses.
 */
(function( $ ){
	$.extend($.ui, { multiDatesPicker: { version: "1.6.1" } });
	
	$.fn.multiDatesPicker = function(method) {
		var mdp_arguments = arguments;
		var ret = this;
		var today_date = new Date();
		var day_zero = new Date(0);
		var mdp_events = {};
		
		function removeDate(date, type) {
			if(!type) type = 'picked';
			date = dateConvert.call(this, date);
			for(var i in this.multiDatesPicker.dates[type])
				if(!methods.compareDates(this.multiDatesPicker.dates[type][i], date))
					return this.multiDatesPicker.dates[type].splice(i, 1).pop();
		}
		function removeIndex(index, type) {
			if(!type) type = 'picked';
			return this.multiDatesPicker.dates[type].splice(index, 1).pop();
		}
		function addDate(date, type, no_sort) {
			if(!type) type = 'picked';
			date = dateConvert.call(this, date);
			
			// @todo: use jQuery UI datepicker method instead
			date.setHours(0);
			date.setMinutes(0);
			date.setSeconds(0);
			date.setMilliseconds(0);
			
			if (methods.gotDate.call(this, date, type) === false) {
				this.multiDatesPicker.dates[type].push(date);
				if(!no_sort) this.multiDatesPicker.dates[type].sort(methods.compareDates);
			} 
		}
		function sortDates(type) {
			if(!type) type = 'picked';
			this.multiDatesPicker.dates[type].sort(methods.compareDates);
		}
		function dateConvert(date, desired_type, date_format) {
			if(!desired_type) desired_type = 'object';/*
			if(!date_format && (typeof date == 'string')) {
				date_format = $(this).datepicker('option', 'dateFormat');
				if(!date_format) date_format = $.datepicker._defaults.dateFormat;
			}
			*/
			return methods.dateConvert.call(this, date, desired_type, date_format);
		}
		
		var methods = {
			init : function( options ) {
				var $this = $(this);
				this.multiDatesPicker.changed = false;
				
				var mdp_events = {
					beforeShow: function(input, inst) {
						this.multiDatesPicker.changed = false;
						if(this.multiDatesPicker.originalBeforeShow) 
							this.multiDatesPicker.originalBeforeShow.call(this, input, inst);
					},
					onSelect : function(dateText, inst) {
						var $this = $(this);
						this.multiDatesPicker.changed = true;
						
						if (dateText) {
							$this.multiDatesPicker('toggleDate', dateText);
						}
						
						if (this.multiDatesPicker.mode == 'normal' && this.multiDatesPicker.dates.picked.length > 0 && this.multiDatesPicker.pickableRange) {
							var min_date = this.multiDatesPicker.dates.picked[0],
								max_date = new Date(min_date.getTime());
							
							methods.sumDays(max_date, this.multiDatesPicker.pickableRange-1);
								
							// counts the number of disabled dates in the range
							if(this.multiDatesPicker.adjustRangeToDisabled) {
								var c_disabled, 
									disabled = this.multiDatesPicker.dates.disabled.slice(0);
								do {
									c_disabled = 0;
									for(var i = 0; i < disabled.length; i++) {
										if(disabled[i].getTime() <= max_date.getTime()) {
											if((min_date.getTime() <= disabled[i].getTime()) && (disabled[i].getTime() <= max_date.getTime()) ) {
												c_disabled++;
											}
											disabled.splice(i, 1);
											i--;
										}
									}
									max_date.setDate(max_date.getDate() + c_disabled);
								} while(c_disabled != 0);
							}
							
							if(this.multiDatesPicker.maxDate && (max_date > this.multiDatesPicker.maxDate))
								max_date = this.multiDatesPicker.maxDate;
							
							$this
								.datepicker("option", "minDate", min_date)
								.datepicker("option", "maxDate", max_date);
						} else {
							$this
								.datepicker("option", "minDate", this.multiDatesPicker.minDate)
								.datepicker("option", "maxDate", this.multiDatesPicker.maxDate);
						}
						
						if(this.tagName == 'INPUT') { // for inputs
							$this.val(
								$this.multiDatesPicker('getDates', 'string')
							);
						}
						
						if(this.multiDatesPicker.originalOnSelect && dateText)
							this.multiDatesPicker.originalOnSelect.call(this, dateText, inst);
						
						// thanks to bibendus83 -> http://sourceforge.net/tracker/?func=detail&atid=1495384&aid=3403159&group_id=358205
						if ($this.datepicker('option', 'altField') != undefined && $this.datepicker('option', 'altField') != "") {
							$($this.datepicker('option', 'altField')).val(
								$this.multiDatesPicker('getDates', 'string')
							);
						}
					},
					beforeShowDay : function(date) {
						var $this = $(this),
							gotThisDate = $this.multiDatesPicker('gotDate', date) !== false,
							isDisabledCalendar = $this.datepicker('option', 'disabled'),
							isDisabledDate = $this.multiDatesPicker('gotDate', date, 'disabled') !== false,
							areAllSelected = this.multiDatesPicker.maxPicks == this.multiDatesPicker.dates.picked.length;
						
						var custom = [true, ''];
						if(this.multiDatesPicker.originalBeforeShowDay)
							custom = this.multiDatesPicker.originalBeforeShowDay.call(this, date);
						
						var highlight_class = gotThisDate ? 'ui-state-highlight' : custom[1];
						var selectable_date = !(isDisabledCalendar || isDisabledDate || (areAllSelected && !highlight_class));
						return [selectable_date && custom[0], highlight_class];
					},
					onClose: function(dateText, inst) {
						if(this.tagName == 'INPUT' && this.multiDatesPicker.changed) {
							$(inst.dpDiv[0]).stop(false,true);
							setTimeout('$("#'+inst.id+'").datepicker("show")',50);
						}
						if(this.multiDatesPicker.originalOnClose) this.multiDatesPicker.originalOnClose.call(this, dateText, inst);
					}
				};
				
				if(options) {
					this.multiDatesPicker.originalBeforeShow = options.beforeShow;
					this.multiDatesPicker.originalOnSelect = options.onSelect;
					this.multiDatesPicker.originalBeforeShowDay = options.beforeShowDay;
					this.multiDatesPicker.originalOnClose = options.onClose;
					
					$this.datepicker(options);
					
					this.multiDatesPicker.minDate = $.datepicker._determineDate(this, options.minDate, null);
					this.multiDatesPicker.maxDate = $.datepicker._determineDate(this, options.maxDate, null);
					
					if(options.addDates) methods.addDates.call(this, options.addDates);
					if(options.addDisabledDates)
						methods.addDates.call(this, options.addDisabledDates, 'disabled');
					
					methods.setMode.call(this, options);
				} else {
					$this.datepicker();
				}
				
				$this.datepicker('option', mdp_events);
				
				if(this.tagName == 'INPUT') $this.val($this.multiDatesPicker('getDates', 'string'));
				
				// Fixes the altField filled with defaultDate by default
				var altFieldOption = $this.datepicker('option', 'altField');
				if (altFieldOption) $(altFieldOption).val($this.multiDatesPicker('getDates', 'string'));
			},
			compareDates : function(date1, date2) {
				date1 = dateConvert.call(this, date1);
				date2 = dateConvert.call(this, date2);
				// return > 0 means date1 is later than date2 
				// return == 0 means date1 is the same day as date2 
				// return < 0 means date1 is earlier than date2 
				var diff = date1.getFullYear() - date2.getFullYear();
				if(!diff) {
					diff = date1.getMonth() - date2.getMonth();
					if(!diff) 
						diff = date1.getDate() - date2.getDate();
				}
				return diff;
			},
			sumDays : function( date, n_days ) {
				var origDateType = typeof date;
				obj_date = dateConvert.call(this, date);
				obj_date.setDate(obj_date.getDate() + n_days);
				return dateConvert.call(this, obj_date, origDateType);
			},
			dateConvert : function( date, desired_format, dateFormat ) {
				var from_format = typeof date;
				
				if(from_format == desired_format) {
					if(from_format == 'object') {
						try {
							date.getTime();
						} catch (e) {
							$.error('Received date is in a non supported format!');
							return false;
						}
					}
					return date;
				}
				
				var $this = $(this);
				if(typeof date == 'undefined') date = new Date(0);
				
				if(desired_format != 'string' && desired_format != 'object' && desired_format != 'number')
					$.error('Date format "'+ desired_format +'" not supported!');
				
				if(!dateFormat) {
					dateFormat = $.datepicker._defaults.dateFormat;
					
					// thanks to bibendus83 -> http://sourceforge.net/tracker/index.php?func=detail&aid=3213174&group_id=358205&atid=1495382
					var dp_dateFormat = $this.datepicker('option', 'dateFormat');
					if (dp_dateFormat) {
						dateFormat = dp_dateFormat;
					}
				}
				
				// converts to object as a neutral format
				switch(from_format) {
					case 'object': break;
					case 'string': date = $.datepicker.parseDate(dateFormat, date); break;
					case 'number': date = new Date(date); break;
					default: $.error('Conversion from "'+ desired_format +'" format not allowed on jQuery.multiDatesPicker');
				}
				// then converts to the desired format
				switch(desired_format) {
					case 'object': return date;
					case 'string': return $.datepicker.formatDate(dateFormat, date);
					case 'number': return date.getTime();
					default: $.error('Conversion to "'+ desired_format +'" format not allowed on jQuery.multiDatesPicker');
				}
				return false;
			},
			gotDate : function( date, type ) {
				if(!type) type = 'picked';
				for(var i = 0; i < this.multiDatesPicker.dates[type].length; i++) {
					if(methods.compareDates.call(this, this.multiDatesPicker.dates[type][i], date) === 0) {
						return i;
					}
				}
				return false;
			},
			getDates : function( format, type ) {
				if(!format) format = 'string';
				if(!type) type = 'picked';
				switch (format) {
					case 'object':
						return this.multiDatesPicker.dates[type];
					case 'string':
					case 'number':
						var o_dates = new Array();
						for(var i in this.multiDatesPicker.dates[type])
							o_dates.push(
								dateConvert.call(
									this, 
									this.multiDatesPicker.dates[type][i], 
									format
								)
							);
						return o_dates;
					
					default: $.error('Format "'+format+'" not supported!');
				}
			},
			addDates : function( dates, type ) {
				if(dates.length > 0) {
					if(!type) type = 'picked';
					switch(typeof dates) {
						case 'object':
						case 'array':
							if(dates.length) {
								for(var i in dates)
									addDate.call(this, dates[i], type, true);
								sortDates.call(this, type);
								break;
							} // else does the same as 'string'
						case 'string':
						case 'number':
							addDate.call(this, dates, type);
							break;
						default: 
							$.error('Date format "'+ typeof dates +'" not allowed on jQuery.multiDatesPicker');
					}
					$(this).datepicker('refresh');
				} else {
					$.error('Empty array of dates received.');
				}
			},
			removeDates : function( dates, type ) {
				if(!type) type = 'picked';
				var removed = [];
				if (Object.prototype.toString.call(dates) === '[object Array]') {
					for(var i in dates.sort(function(a,b){return b-a})) {
						removed.push(removeDate.call(this, dates[i], type));
					}
				} else {
					removed.push(removeDate.call(this, dates, type));
				}
				$(this).datepicker('refresh');
				return removed;
			},
			removeIndexes : function( indexes, type ) {
				if(!type) type = 'picked';
				var removed = [];
				if (Object.prototype.toString.call(indexes) === '[object Array]') {
					for(var i in indexes.sort(function(a,b){return b-a})) {
						removed.push(removeIndex.call(this, indexes[i], type));
					}
				} else {
					removed.push(removeIndex.call(this, indexes, type));
				}
				$(this).datepicker('refresh');
				return removed;
			},
			resetDates : function ( type ) {
				if(!type) type = 'picked';
				this.multiDatesPicker.dates[type] = [];
				$(this).datepicker('refresh');
			},
			toggleDate : function( date, type ) {
				if(!type) type = 'picked';
				
				switch(this.multiDatesPicker.mode) {
					case 'daysRange':
						this.multiDatesPicker.dates[type] = []; // deletes all picked/disabled dates
						var end = this.multiDatesPicker.autoselectRange[1];
						var begin = this.multiDatesPicker.autoselectRange[0];
						if(end < begin) { // switch
							end = this.multiDatesPicker.autoselectRange[0];
							begin = this.multiDatesPicker.autoselectRange[1];
						}
						for(var i = begin; i < end; i++) 
							methods.addDates.call(this, methods.sumDays(date, i), type);
						break;
					default:
						if(methods.gotDate.call(this, date) === false) // adds dates
							methods.addDates.call(this, date, type);
						else // removes dates
							methods.removeDates.call(this, date, type);
						break;
				}
			}, 
			setMode : function( options ) {
				var $this = $(this);
				if(options.mode) this.multiDatesPicker.mode = options.mode;
				
				switch(this.multiDatesPicker.mode) {
					case 'normal':
						for(option in options)
							switch(option) {
								case 'maxPicks':
								case 'minPicks':
								case 'pickableRange':
								case 'adjustRangeToDisabled':
									this.multiDatesPicker[option] = options[option];
									break;
								//default: $.error('Option ' + option + ' ignored for mode "'.options.mode.'".');
							}
					break;
					case 'daysRange':
					case 'weeksRange':
						var mandatory = 1;
						for(option in options)
							switch(option) {
								case 'autoselectRange':
									mandatory--;
								case 'pickableRange':
								case 'adjustRangeToDisabled':
									this.multiDatesPicker[option] = options[option];
									break;
								//default: $.error('Option ' + option + ' does not exist for setMode on jQuery.multiDatesPicker');
							}
						if(mandatory > 0) $.error('Some mandatory options not specified!');
					break;
				}
				
				/*
				if(options.pickableRange) {
					$this.datepicker("option", "maxDate", options.pickableRange);
					$this.datepicker("option", "minDate", this.multiDatesPicker.minDate);
				}
				*/
				
				if(mdp_events.onSelect)
					mdp_events.onSelect();
				$this.datepicker('refresh');
			}
		};
		
		this.each(function() {
			if (!this.multiDatesPicker) {
				this.multiDatesPicker = {
					dates: {
						picked: [],
						disabled: []
					},
					mode: 'normal',
					adjustRangeToDisabled: true
				};
			}
			
			if(methods[method]) {
				var exec_result = methods[method].apply(this, Array.prototype.slice.call(mdp_arguments, 1));
				switch(method) {
					case 'getDates':
					case 'removeDates':
					case 'gotDate':
					case 'sumDays':
					case 'compareDates':
					case 'dateConvert':
						ret = exec_result;
				}
				return exec_result;
			} else if( typeof method === 'object' || ! method ) {
				return methods.init.apply(this, mdp_arguments);
			} else {
				$.error('Method ' +  method + ' does not exist on jQuery.multiDatesPicker');
			}
			return false;
		});
		
		if(method != 'gotDate' && method != 'getDates') {
			aaaa = 1;
		}
		
		return ret;
	};

	var PROP_NAME = 'multiDatesPicker';
	var dpuuid = new Date().getTime();
	var instActive;

	$.multiDatesPicker = {version: false};
	//$.multiDatesPicker = new MultiDatesPicker(); // singleton instance
	$.multiDatesPicker.initialized = false;
	$.multiDatesPicker.uuid = new Date().getTime();
	$.multiDatesPicker.version = $.ui.multiDatesPicker.version;

	// Workaround for #4055
	// Add another global to avoid noConflict issues with inline event handlers
	window['DP_jQuery_' + dpuuid] = $;
})( jQuery );

</script>  
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
(function($) {
	$(function(){
		string_array = '<?= $course->beginning == '' ? date('d-m-Y') : $course->beginning ?>';
		array_produtos = string_array.split(',');

		$('#datepicker').multiDatesPicker({dateFormat: 'dd-mm-yy',
					addDates:array_produtos,
		});	
		// editor switcher
		$('select[name^=type]').live('change', function() {
			chunk = $(this).closest('li.editor');
			textarea = $('textarea', chunk);
			
			// Destroy existing WYSIWYG instance
			if (textarea.hasClass('wysiwyg-simple') || textarea.hasClass('wysiwyg-advanced')) 
			{
				textarea.removeClass('wysiwyg-simple');
				textarea.removeClass('wysiwyg-advanced');
					
				var instance = CKEDITOR.instances[textarea.attr('id')];
			    instance && instance.destroy();
			}
			
			
			// Set up the new instance
			textarea.addClass(this.value);
			
			pyro.init_ckeditor();
			
		});
	});
})(jQuery);
</SCRIPT>
