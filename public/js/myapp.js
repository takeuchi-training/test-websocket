// window.Echo.private('App.Models.User.' + $('input[name=userId]').val())
//     .notification((notification) => {
//         console.log("Fuck you!");
//     });

window.Echo
	.join('admin.department.' + $('input[name=departmentId]').val())
	.here((users) => {
		console.log('Here: ');
		console.log(users);
	})
	.joining((user) => {
		console.log('Joining: ' + user.name);
	})
	.leaving((user) => {
		console.log('Leaving: ' + user.name);
	})
	.error((error) => {
		console.error(error);
	})
	.listen('NewApplicationEvent', (e) => {
		console.log(e);
		$('#adminApplications').prepend(
			'<div class="d-flex justify-content-between">' +
				'<div class="d-flex align-items-start">' +
				'<h5>' +
				e.application.title +
				'</h5>' +
				'<a class="ms-1" href="/admin/applications/' +
				e.application.id +
				'">' +
				'<i class="bi bi-box-arrow-in-up-right"></i>' +
				'</a>' +
				'</div>' +
				'<small>created at ' +
				e.application.created_at +
				'</small>' +
				'</div>' +
				'<strong>From employee: ' +
				e.user.name +
				'</strong>' +
				'<hr>'
		);
	});
