// required arguments
// onclick = "deleteItem(this)"
// data-route = "{{ route('admin.user.delete',['id' => $user->id]) }}"

function deleteItem(e) {

    let route = e.getAttribute('data-route');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            if (result.isConfirmed) {

                // Simulate a mouse click:
                window.location.href = route;

            }

        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Last Operation was cancelled',
                'error'
            );
        }
    });

}

function confirmation(e) {

    let route = e.getAttribute('data-route');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'Heads up',
        text: "You're About to log out of admin dashboard to dealer dashboard.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sure, Proceed!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            if (result.isConfirmed) {

                // Simulate a mouse click:
                window.location.href = route;

            }

        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Redirection is Cancelled',
                'error'
            );
        }
    });

}

function tokenWarning(e) {

    let route = e.getAttribute('data-route');

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'Heads up',
        text: "You're About to Change the API Token, you're Developers needs to be avail new token after this refresh",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sure, Proceed!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            if (result.isConfirmed) {

                // Simulate a mouse click:
                window.location.href = route;

            }

        } else if (
            result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire(
                'Cancelled',
                'Redirection is Cancelled',
                'error'
            );
        }
    });

}