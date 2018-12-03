jQuery(function ($) {
	var ENTER = 13;
	var ESCAPE = 27;
	function escapeHtml(text) {
		return text.replace(/[\"&'\/<>]/g, function (a) {
			return {
				'"': '&quot;', '&': '&amp;', "'": '&#39;',
				'/': '&#47;', '<': '&lt;', '>': '&gt;'
			}[a];
		});
	}
	var ToDo = {
		init: function () {
			this.import();
			$('.toggle-all').change(this.toggleAll);
			$('.toggle').change(this.toggle);
			$('.filters a').click(this.filterSet);
			$('.destroy').click(this.deleteToggle);
			$('.clear-completed').click(this.clearCompleted);
			$('.new-todo').keyup(this.create);
			$('.todo-list li').dblclick(this.edit);
			$('.edit').keyup(this.editKey);
			$('.edit').focusout(this.editOut);
			this.filterInit();
			this.update();
		},
		update: function () {
			$('.todo-count strong').text($('.toggle:not(:checked)').length);
			$('.toggle-all').prop("checked", $('.todo-list :checked').length == $('.todo-list :checkbox').length);
			if ($('.todo-list :checked').length > 0) {
				$('.clear-completed').fadeIn(0);
			} else {
				$('.clear-completed').fadeOut(0);
			}
			ToDo.export();
			ToDo.filters();
		},
		export: function () {
			var data = {};
			$.each($('.todo-list li'), function (i, val) {
				data[$(val).find('.edit').val()] = $(val)[0].className;
			})
			localStorage.setItem('todo-list', JSON.stringify(data));
		},
		import: function () {
			var data = JSON.parse(localStorage.getItem('todo-list'));
			if (data) {
				$('.todo-list li').remove()
				$.each(data, function (value, Class) {
					ToDo.addToggle([value, Class]);
				})
			}
		},
		edit: function () {
			$(this).addClass('editing');
			$(this).find('.edit').focus();
		},
		editKey: function (e) {
			if ((e.which == ENTER) || (e.which == ESCAPE)) {
				if ($(this).val().trim().length == 0) {
					$(this).parent().remove();
					ToDo.update();
				}
				$(this).blur();
			} else {
				$(this).parent().find('label').text($(this).val().trim());
			}
		},
		editOut: function () {
			$(this).parent().removeClass('editing');
			ToDo.update();
		},
		addToggle: function (value) {
			var checked = (value[1] == 'completed') ? "checked" : "";
			$('.todo-list').append(`
										<li class="`+ value[1]+`">
											<div class="view">
												<input class="toggle" type="checkbox" ` + checked + `>
												<label>` + escapeHtml(value[0]) + `</label>
												<button class="destroy"></button>
											</div>
											<input class="edit" value="` + escapeHtml(value[0]) + `">
										</li>
								`);
		},
		create: function (e) {
			if ((e.which == ENTER) && ($(this).val().trim().length > 0)) {
				ToDo.addToggle([$(this).val().trim(), ""]);
				$(this).val("");
				ToDo.export();
				ToDo.init();
			}
		},
		toggleAll: function () {
			$('.toggle').prop('checked', $(this).prop("checked"));
			$('.todo-list li').prop("class", (($(this).prop("checked")) ? "completed" : ""));
			ToDo.update();
		},
		toggle: function () {
			$('.todo-list li').eq($('.toggle').index(this)).prop("class", (($(this).prop("checked")) ? "completed" : ""));
			ToDo.update();
		},
		deleteToggle: function () {
			$(this).parent().parent().remove();
			ToDo.update();
		},
		clearCompleted: function () {
			$('.todo-list li.completed').remove();
			ToDo.update();
		},
		filterInit: function () {
			var hash = location.hash.split('#/')[1];
			switch (hash) {
				case 'active':
					$('.filters a:contains("Active")').click()
					break;
				case 'completed':
					$('.filters a:contains("Completed")').click()
					break;
			}
		},
		filterSet: function () {
			$('.filters a').prop("class", "");
			$(this).prop("class", "selected");
			ToDo.filters();
		},
		filters: function () {
			$('.todo-list li').fadeOut(0);
			switch ($('.filters a.selected')[0].text) {
				case 'All':
					$('.todo-list li').fadeIn(0);
					break;
				case 'Active':
					$('.todo-list li:not(.completed)').fadeIn(0);
					break;
				case 'Completed':
					$('.todo-list li.completed').fadeIn(0);
					break;
			}
		}
	}
	ToDo.init();
})
