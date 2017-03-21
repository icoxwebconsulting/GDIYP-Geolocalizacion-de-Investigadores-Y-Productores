function drawInfobox(url, infoboxContent, json, i){
    var color = '';
    if(json[i].user.roles.includes("ROLE_INVESTIGATOR")) { color = 'red'; }
    if(json[i].user.roles.includes("ROLE_PRODUCER")) { color = 'blue'; }
    // if( json[i].price )        { var price = '<div class="price">' + json[i].price +  '</div>' }
    //     else                        { price = '' }
    if(json[i].id)             { var id = json[i].id }
        else                        { id = '' }
    // if(json[i].type)           { var type = json[i].type }
    //     else                        { type = '' }
    // if(json[i].title)          { var title = json[i].title }
    //     else                        { title = '' }
    // if(json[i].location)       { var location = json[i].location }
    //     else                        { location = '' }
    // if(json[i].gallery[0])     { var gallery = json[i].gallery[0] }
    //     else                        { gallery[0] = '../img/default-item.jpg' }

    var ibContent = '';
    ibContent =
    '<div class="infobox ' + color + '">' +
        '<div class="inner">' +
            '<div class="image">' +
                '<div class="overlay">' +
                    '<div class="wrapper">' +
                        '<a href="#" class="quick-view" data-toggle="modal" data-target="#modal" id="' + id + '">Quick View</a>' +
                        '<hr>' +
                        '<a href="' + url +  '" class="detail">Go to Detail</a>' +
                    '</div>' +
                '</div>' +
                '<a href="' + url +  '" class="description">' +
                    '<div class="meta">' +
                        '<h2>' + json[i].user.firstName +  ' ' + json[i].user.lastName +  '</h2>' +
                        '<figure>' + json[i].address.address.substr(0,30) +  '</figure>' +
                        '<i class="fa fa-angle-right"></i>' +
                    '</div>' +
                '</a>' +
                '<img src="../uploads/user/profile/' + json[i].user.imageName +  '">' +
            '</div>' +
        '</div>' +
    '</div>';

    return ibContent;
}