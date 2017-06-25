function logout() {
    swal({
        title: "Logout?",
        text: "You will exit whole system",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, Logout!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        	location.href="/logout.php"
    });
}
