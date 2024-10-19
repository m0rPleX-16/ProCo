var tbody = document.querySelector("tbody");
var pageUl = document.querySelector(".pagination");
var itemShow = document.querySelector("#itemperpage");
var tr = tbody.querySelectorAll("tr");
var emptyBox = [];
var index = 1;
var itemPerPage = 10;
let limit = 5; // Default pagination limit

for (let i = 0; i < tr.length; i++) {
    emptyBox.push(tr[i]);
}

itemShow.onchange = giveTrPerPage;
function giveTrPerPage() {
    itemPerPage = Number(this.value);
    displayPage(itemPerPage);
    pageGenerator(itemPerPage);
    pageRunner();
}

function displayPage(limit) {
    tbody.innerHTML = '';
    for (let i = 0; i < limit; i++) {
        tbody.appendChild(emptyBox[i]);
    }
    const pageNum = pageUl.querySelectorAll('.list');
    pageNum.forEach(n => n.remove());
}
displayPage(itemPerPage);

function pageGenerator(getem) {
    const num_of_tr = emptyBox.length;
    if (num_of_tr <= getem) {
        pageUl.style.display = 'none';
    } else {
        pageUl.style.display = 'flex';
        const num_Of_Page = Math.ceil(num_of_tr / getem);
        const maxVisiblePages = 5;

        // Clear existing pagination buttons
        const existingButtons = pageUl.querySelectorAll('.list');
        existingButtons.forEach(btn => btn.remove());

        let startPage = 1;
        let endPage = Math.min(maxVisiblePages, num_Of_Page);

        for (let i = startPage; i <= endPage; i++) {
            const li = document.createElement('li');
            li.className = 'list';
            const a = document.createElement('a');
            a.href = '#';
            a.innerText = i;
            a.setAttribute('data-page', i);
            li.appendChild(a);
            pageUl.insertBefore(li, pageUl.querySelector('.next'));
        }

        if (num_Of_Page > maxVisiblePages) {
            const ellipsis = document.createElement('li');
            ellipsis.className = 'list ellipsis';
            ellipsis.innerHTML = '...';
            pageUl.insertBefore(ellipsis, pageUl.querySelector('.next'));

            const lastLi = document.createElement('li');
            lastLi.className = 'list';
            const lastA = document.createElement('a');
            lastA.href = '#';
            lastA.innerText = num_Of_Page;
            lastA.setAttribute('data-page', num_Of_Page);
            lastLi.appendChild(lastA);
            pageUl.insertBefore(lastLi, pageUl.querySelector('.next'));
        }
    }
    pageRunner();
}

function updatePagination(currentPage, totalPages) {
    const maxVisiblePages = 5;
    let startPage, endPage;
    if (totalPages <= maxVisiblePages) {
        startPage = 1;
        endPage = totalPages;
    } else {
        if (currentPage <= 3) {
            startPage = 1;
            endPage = maxVisiblePages;
        } else if (currentPage + 2 >= totalPages) {
            startPage = totalPages - 4;
            endPage = totalPages;
        } else {
            startPage = currentPage - 2;
            endPage = currentPage + 2;
        }
    }

    // Clear existing pagination buttons
    const existingButtons = pageUl.querySelectorAll('.list');
    existingButtons.forEach(btn => btn.remove());

    for (let i = startPage; i <= endPage; i++) {
        const li = document.createElement('li');
        li.className = 'list';
        const a = document.createElement('a');
        a.href = '#';
        a.innerText = i;
        a.setAttribute('data-page', i);
        li.appendChild(a);
        pageUl.insertBefore(li, pageUl.querySelector('.next'));
    }

    if (totalPages > maxVisiblePages) {
        if (endPage < totalPages) {
            const ellipsis = document.createElement('li');
            ellipsis.className = 'list ellipsis';
            ellipsis.innerHTML = '...';
            pageUl.insertBefore(ellipsis, pageUl.querySelector('.next'));
        }

        const lastLi = document.createElement('li');
        lastLi.className = 'list';
        const lastA = document.createElement('a');
        lastA.href = '#';
        lastA.innerText = totalPages;
        lastA.setAttribute('data-page', totalPages);
        lastLi.appendChild(lastA);
        pageUl.insertBefore(lastLi, pageUl.querySelector('.next'));
    }
    pageRunner();
}

function pageRunner() {
    let pageLink = pageUl.querySelectorAll("a");
    let lastPage = Math.ceil(emptyBox.length / itemPerPage);

    for (let button of pageLink) {
        button.onclick = e => {
            e.preventDefault();
            const page_num = e.target.getAttribute('data-page');
            const page_mover = e.target.getAttribute('id');
            if (page_num != null) {
                index = Number(page_num);
            } else {
                if (page_mover === "next") {
                    index++;
                    if (index > lastPage) {
                        index = lastPage;
                    }
                } else {
                    index--;
                    if (index < 1) {
                        index = 1;
                    }
                }
            }
            updatePagination(index, lastPage);
            pageMaker(index, itemPerPage);
        }
    }
}

// Initial setup
let lastPage = Math.ceil(emptyBox.length / itemPerPage);
updatePagination(1, lastPage);
pageRunner();
pageMaker(index, itemPerPage);

function pageMaker(index, item_per_page) {
    const start = (index - 1) * item_per_page;
    const end = start + item_per_page;
    const current_page = emptyBox.slice(start, end);
    tbody.innerHTML = "";
    for (let j = 0; j < current_page.length; j++) {
        let item = current_page[j];
        tbody.appendChild(item);
    }
    const activePage = pageUl.querySelectorAll('.list a');
    activePage.forEach(e => { e.parentElement.classList.remove("active"); });
    const pageNumbers = Array.from(pageUl.querySelectorAll('.list a'));
    pageNumbers.forEach(a => {
        if (a.getAttribute('data-page') == index) {
            a.parentElement.classList.add("active");
        }
    });
}

// Adjust pagination when the number of items per page changes
itemShow.onchange = giveTrPerPage;

// Search functionality
var search = document.getElementById("search");
search.onkeyup = e => {
    const text = e.target.value;
    for (let i = 0; i < tr.length; i++) {
        const matchText = tr[i].querySelectorAll("td")[2].innerText;
        if (matchText.toLowerCase().indexOf(text.toLowerCase()) > -1) {
            tr[i].style.display = "table-row";
        } else {
            tr[i].style.display = "none";
        }
    }
}
