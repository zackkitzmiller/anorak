(function() {
	!function(g,s,q,r,d){r=g[r]=g[r]||function(){(r.q=r.q||[]).push(
	arguments)};d=s.createElement(q);q=s.getElementsByTagName(q)[0];
	d.src='//d1l6p2sc9645hc.cloudfront.net/tracker.js';q.parentNode.
	insertBefore(d,q)}(window,document,'script','_gs');
	_gs('GSN-279675-G');

	/**
	 * This file should only be used for logged in users.
	 */

	$('button[type=submit][name=repo]').on('click', function(e) {
		e.preventDefault();

		var $this = $(this);

		var _token = $('input[name=_token]').val(),
			action = $this.data('action')
			repoID = $this.data('repoid');

		$.ajax({
			async: true,
			url: '/repo/' + repoID + '/' + action,
			type: 'POST',
			data: {
				'_token': _token
			},
			dataType: 'json',
			success: function(d) {
				if(d.success && d.errors.length === 0) {
					if(action === 'activate') {
						$this.removeClass('btn-default').addClass('btn-danger').data('action', 'deactivate').html('Deactivate');
					}else{
						$this.removeClass('btn-danger').addClass('btn-default').data('action', 'activate').html('Activate');
					}
				}else{
					if(action === 'activate') {
						alert('Could not activate repository.');
					}else{
						alert('Could not deactivate repository.');
					}
				}
			},
			error: function(a, b, c) {
				console.log(a, b, c);
			}
		});

		return false;
	});
}());
