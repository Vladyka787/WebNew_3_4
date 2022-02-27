document.addEventListener("DOMContentLoaded", function () {

    let morePostsBtn = document.getElementById('container_add__button');
    let vstavka = document.getElementById('vstavka_post');

    if (!!morePostsBtn) {
        morePostsBtn.addEventListener('click', loadPostsListener);
    }

    function loadPostsListener(event) {
        event.preventDefault();

        let page = parseInt(event.target.getAttribute('data-next-page'));
        if (isNaN(page)) {
            page = 0;
        }
        let url = event.target.href + '?page=' + page;

        console.log(url);

        fetch(url)
            .then(response => response.text())
            .then((result) => {
                if (result.length > 0) {
                    vstavka.insertAdjacentHTML('beforeend', result);
                    morePostsBtn.setAttribute('data-next-page', (page + 1).toString());
                } else {
                    morePostsBtn.remove();
                }
            })
            .catch(error => console.log(error));

    }
})