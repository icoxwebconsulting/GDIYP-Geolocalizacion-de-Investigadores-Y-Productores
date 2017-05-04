function drawInfobox(url, infoboxContent, json, i){
    var color = '';
    if(json[i].user.roles.includes("ROLE_INVESTIGATOR")) { color = 'red'; title = 'Investigator'; }
    if(json[i].user.roles.includes("ROLE_PRODUCER")) { color = 'blue'; title = 'Producer'; }
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
    if(json[i].user.imageName)     { var photo = '../uploads/user/profile/' + json[i].user.imageName; }
        else                        { photo = '/assets/spotter/img/items/1.jpg' }

    var ibContent = '';
    if(json[i].user.roles.includes("ROLE_INVESTIGATOR")) {
        ibContent =
        '<div class="infobox ' + color + '">' +
            '<div class="inner">' +
                '<div class="image">' +
                    '<div class="overlay">' +
                        '<div class="wrapper">' +
                            // '<a href="#" class="quick-view" data-toggle="modal" data-target="#modal" id="' + id + '">Quick View</a>' +
                            // '<hr>' +
                            '<a href="' + url +  '" class="detail">Ir al detalle</a>' +
                        '</div>' +
                    '</div>' +
                    '<a href="' + url +  '" class="description">' +
                        '<div class="meta">' +
                            '<h2>' + json[i].user.firstName +  ' ' + json[i].user.lastName +  '</h2>' +
                            '<figure>' + json[i].address.address.substr(0,30) +  '</figure>' +
                            '<i class="fa fa-angle-right"></i>' +
                        '</div>' +
                    '</a>' +
                    '<img src="' + photo +  '">' +
                '</div>' +
            '</div>' +
        '</div>';
    }
    
    if(json[i].user.roles.includes("ROLE_PRODUCER")) {
        ibContent =
        '<div class="infobox ' + color + '">' +
            '<div class="inner">' +
                '<div class="image">' +
                    '<div class="overlay">' +
                        '<div class="wrapper">' +
                            // '<a href="#" class="quick-view" data-toggle="modal" data-target="#modal" id="' + id + '">Quick View</a>' +
                            // '<hr>' +
                            //'<a href="' + url +  '" class="detail">Ir al detalle</a>' +
                        '</div>' +
                    '</div>' +
                    //'<a href="' + url +  '" class="description">' +
                    '<a href="#" class="description">' +
                        '<div class="meta">' +
                            '<h2>' + json[i].user.firstName +  ' ' + json[i].user.lastName +  '</h2>' +
                            '<figure>' + json[i].address.address.substr(0,30) +  '</figure>' +
                            //'<i class="fa fa-angle-right"></i>' +
                        '</div>' +
                    '</a>' +
                    '<img src="' + photo +  '">' +
                '</div>' +
            '</div>' +
        '</div>';
    }
    
    return ibContent;
}