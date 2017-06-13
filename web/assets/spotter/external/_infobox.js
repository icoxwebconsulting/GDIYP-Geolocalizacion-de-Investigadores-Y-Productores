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

    var name = '';
    var institution = '';
    var knowledge = '';
    var description = '';
    var practiceType = '';
    if (json[i].user.roles.includes("ROLE_INVESTIGATOR")) {
        name = json[i].user.firstName +  ' ' + json[i].user.lastName;
        institution = json[i].institution.name;
        knowledge = json[i].knowledge.knowledgeArea.name;   
    }
    else if (json[i].user.roles.includes("ROLE_PRODUCER")) {
        name = json[i].practiceName;
        description = json[i].description;        
        if (json[i].productiveUndertaking!=null) {
            practiceType = 'Tipo: Emprendimiento Productivo';
        }
        if (json[i].marketingSpaces!=null) {
            practiceType = 'Tipo: Espacios de Comercialización';
        }
        if (json[i].professionalServices!=null) {
            practiceType = 'Tipo: Servicios Profesionales';
        }        
        if (json[i].institutionalProject!=null) {
            practiceType = 'Tipo: Proyectos Institucionales';
        }
        if (json[i].promotionGroup!=null) {
            practiceType = 'Tipo: Grupos de Promoción';
        }
    }

    var ibContent = '';
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
                        '<h2>' + name +  '</h2>' +
                        '<figure>' + json[i].address.address.substr(0,30) +  '</figure>' +
                        '<figure>' + institution +  '</figure>' +
                        '<figure>' + knowledge +  '</figure>' +
                        '<figure>' + practiceType +  '</figure>' +
                        '<figure>' + description +  '</figure>' +
                        '<i class="fa fa-angle-right"></i>' +
                    '</div>' +
                '</a>' +
                '<img src="' + photo +  '">' +
            '</div>' +
        '</div>' +
    '</div>';
    
    return ibContent;
}