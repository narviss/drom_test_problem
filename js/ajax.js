jQuery(function ($) {

	var ajax = {
		init: function () {
			$('a').click(this.getContent);
			$("form").submit(this.ajaxForm);
		},
		ajaxForm: function (e) {
			e.preventDefault();
			$('body').animate({ opacity: 0 }, 0);
			var form = $(this);
			var url = form.attr('action');
			console.log(form.serialize());
			console.log(url);
			$.ajax({
				type: "POST",
				url: url,
				data: form.serialize(),
				context: document.body
			}).done(function (html) {
				$('body').html(html);
				$('body').animate({ opacity: 1 });
			});

		},
		getContent: function (e) {
			if($(this).parent().parent()[0].className == 'filters')
				return false;
			e.preventDefault();
			$('body').animate({ opacity: 0 }, 0);
			$.ajax({
				url: this.href,
				context: document.body
			}).done(function (html) {
				$('body').html(html);
				$('body').animate({ opacity: 1 });
			});

		}
	}
	ajax.init();
})
