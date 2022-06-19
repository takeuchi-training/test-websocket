function formatDatetime($datetimeString) {
	const datetime = new Date($datetimeString);

	return (
		String(datetime.getFullYear()) +
		'-' +
		String(datetime.getMonth()).padStart(2, '0') +
		'-' +
		String(datetime.getDate()).padStart(2, '0') +
		' ' +
		String(datetime.getHours()).padStart(2, '0') +
		':' +
		String(datetime.getMinutes()).padStart(2, '0') +
		':' +
		String(datetime.getSeconds()).padStart(2, '0')
	);
}

function changeBellColor() {
	if ($('#newApplicationList').find('.new-application').length === 0) {
		$('#notificationBell').removeClass('text-danger');
		$('#notificationBell').addClass('text-secondary');
		$('#newApplicationList .no-items').removeClass('d-none');
	} else {
		$('#notificationBell').removeClass('text-secondary');
		$('#notificationBell').addClass('text-danger');
		$('#newApplicationList .no-items').addClass('d-none');
	}
}

changeBellColor();

$('#notificationBell').on('click', function() {
	$('#newApplicationList').slideToggle(50);
});

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
				formatDatetime(e.application.created_at) +
				'</small>' +
				'</div>' +
				'<strong>From employee: ' +
				e.user.name +
				'</strong>' +
				'<hr>'
		);

		$('#newApplicationList').prepend(
			'<div class="new-application list-group-item list-group-item-action d-flex flex-column">' +
				'<a href="http://' +
				window.location.host +
				'/admin/applications/' +
				e.application.id +
				'" class="">' +
				e.user.name +
				' just submitted ' +
				e.application.title +
				' application</a>' +
				'<small>- ' +
				formatDatetime(e.application.created_at) +
				'</div>'
		);

		changeBellColor();
	});
