document.addEventListener("DOMContentLoaded", function () {

    let vrem = document.getElementById("logOut");
    if (!!vrem) {
        vrem.addEventListener("click", function (e) {
            e.preventDefault();

            fetch("/logOut.php")
                .then(response => response.text())
                .then((result) => {
                    if (result == "success") {
                        console.log("Успех");
                        document.location.reload();
                    }
                })
                .catch(error => console.log(error));
        })
    }
})