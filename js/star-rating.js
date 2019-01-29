function showStars(num) {
    var output = "";

    for (var i=1; i <= 5; i++) {
        if (i <= num) {
            output += "<span class='fa fa-star checked'></span>";
        } else {
            output += "<span class='fa fa-star'></span>";
        }
    }

    return output;
}