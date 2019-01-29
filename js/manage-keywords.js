function add_keyword() {
    var traitText = $("#keys option:selected").text();
    var traitValue = $("#keys option:selected").val();

    var level = $('#slider').val();
    var removeButtonCode = "<button class='remove_keyword' onclick=remove_keyword(this) >X</button></li>";

    var starLevel = showStars(level);
    $("#added_traits").append(`<li>${traitText} : ${starLevel} ${removeButtonCode}</li>`);

    $("form").append(`<input class='${traitText}' type='hidden' name='traits[]' value='${traitValue}' />`);
    
    $("form").append(`<input class='${traitText}' type='hidden' name='levels[]' value='${level}' />`);
    $("#keys option:selected").attr('disabled', true);
} 

function remove_keyword(e) {
    $(e).parent().remove();

    var valueHtml = $(e).parent().html();

    var firstWords = [];
    for (var i=0;i<valueHtml.length;i++) {
        var codeLine = valueHtml[i];
        var firstWord = valueHtml.substr(0, valueHtml.indexOf(" "));
        firstWords.push(firstWord);
    }
    
    $(`#keys option:contains(${firstWords[0]})`).removeAttr('disabled');
    $(`input.${firstWords[0]}`).remove();
}