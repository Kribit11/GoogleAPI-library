$(document).ready(function() {
    var item, title, author, publisher, bookLink, bookImg;
    var outputList = document.getElementById("list-output");
    var bookUrl = "https://www.googleapis.com/books/v1/volumes?key=AIzaSyBHEN8U0eIadZ6UDYsyZgn_MNB2EhOKGsQ&q=";
    var placeHldr = '<img src="https://via.placeholder.com/150">';
    var searchData;

    // listener for search button
    $("#search").click(function() {
        outputList.innerHTML = "";
        searchData = $("#search-box").val();

        // handling empty search input field
        if (searchData === "" || searchData === null) {
            displayError();
        }
        else {
            $.ajax({
                url: bookUrl + searchData,
                dataType: "json",
                success: function(res) {
                    console.log(res)
                    if (res.totalItems === 0) {
                        alert("no results!... try again")
                    }
                    else {
                        $("title").animate({"margin-top": "10px"})
                        $(".book-list").css({"visibility": "visible"});
                        displayResults(res)
                        console.log(bookUrl + searchData)

                    }
                },
                error: function() {
                    alert("An error occurred while fetching data. Please try again later.");
                }
            });
        }
        $("#search-box").val("");
    });

    function displayResults(res) {
        for(var i = 0; i < res.items.length; i+=2) {
            item = res.items[i];
            title1 = item.volumeInfo.title;
            author1 = item.volumeInfo.authors;
            publisher1 = item.volumeInfo.publisher;
            bookIsbn1 = item.volumeInfo.industryIdentifiers?.find(id => id.type === 'ISBN_13' || id.type === 'ISBN_10')?.identifier || null
            bookImg1 = item.volumeInfo.imageLinks ? item.volumeInfo.imageLinks.thumbnail : placeHldr;

            item2 = res.items[i + 1];
            title2 = item2.volumeInfo.title;
            author2 = item2.volumeInfo.authors;
            publisher2 = item2.volumeInfo.publisher;
            bookIsbn2 = item2.volumeInfo.industryIdentifiers?.find(id => id.type === 'ISBN_13' || id.type === 'ISBN_10')?.identifier || null
            bookImg2 = item2.volumeInfo.imageLinks ? item2.volumeInfo.imageLinks.thumbnail : placeHldr;

            outputList.innerHTML += '<div class="row mt-4">' + 
                                    formatOutput(bookImg1, title1, author1, publisher1, bookIsbn1) +
                                    formatOutput(bookImg2, title2, author2, publisher2, bookIsbn2) +
                                    '</div>';
        }
    }

    function formatOutput(bookImg, title, author, publisher, bookIsbn) {
        var viewerUrl = 'book.html?isbn=' +bookIsbn;
        var htmlCard = `<div class="col-lg-6">
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="${bookImg}" class="card-img" alt="Book cover for ${title}">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">${title}</h5>
                        <p class="card-text">Author: ${author}</p>
                        <p class="card-text">Publisher: ${publisher}</p>
                        <p class="card-text">ISBN: ${bookIsbn}</p>
                        <a target="_blank" href="${viewerUrl}" class="btn btn-secondary">Read Book</a>
                    </div>
                </div>
            </div>
        </div>`;

        return htmlCard;
    }

    function displayError() {}

});
