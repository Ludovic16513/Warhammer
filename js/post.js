/* Divs / Containers */
const weapon_input = document.getElementById('select_weapon');
const input_armor = document.getElementById('select_armor');
const id_input_hidden = document.getElementById('input_id').value;
const id_user_input_hidden = document.getElementById('id_sheet_user').value;

let nb_requete_terminees = 0;

/* Désactive le champ de choix des unités si toutes les requêtes ne sont pas terminées */
function refresh_unit_select() {
    if(nb_requete_terminees < 5){
        $('#loading').css('display', 'block');
        $('#select_unit').attr('disabled', 'disabled');
    } else {
        $('#loading').css('display', 'none');
        $('#select_unit').removeAttr('disabled');
    }
}

/* Remet une action de suppression sur tous les liens sur suppression */
function refresh_delete_links() {
    $('.remove_unit').click(function () {
        const unit_container_to_remove = $(this).parent();
        const unit_id_to_remove = unit_container_to_remove.children('#unit_id').val();
        const data = {
            delete_id: unit_id_to_remove
        };
        $.ajax({
            url: 'delete_unit.php',
            type: 'GET',
            data: data,
            success: (function () {
                refresh_total_cost();
            })
        });
        $(this).parent('div').remove();
        refresh_army_cost();
    });
}

/* Ajoute une unité depuis les données du formulaire */
function insert_unit() {
    const selected_unit = document.getElementById("select_unit").value;
    const selected_weapon = document.getElementById("select_weapon").value;
    const selected_armor = document.getElementById("select_armor").value;
    const amount = document.getElementById('input_unit_multiply').value;
    const cost = document.getElementById('input_calculator').value;
    const data = {
        insert_amount: amount,
        insert_unit: selected_unit,
        insert_weapon: selected_weapon,
        insert_armor: selected_armor,
        insert_id: id_input_hidden,
        insert_cost: cost
    };
    //const data = `insert_amount=${amount}&insert_unit=${unit}&insert_armor=${armor}&insert_weapon=${weapon}&insert_id=${id_input_hidden}&insert_cost=${cost}`

    $.ajax({
        url: 'insert_unit.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success:(function (data_id){
            $('#army_list').append
            (`<div class="unit">
                <input id="unit_id" type="hidden" value="${data_id}">
                <div class="container_unit">
                <div class="number_unit">${amount}</div>
            <div class="name_unit">${selected_unit}</div>
            <div class="pts"> ${cost} pts</div>
            <input class="total" type="hidden" value="${cost}">
            </div>
            <div class="container_letter">
                <div class="empty"></div>
                <div class="M">M</div>
                <div class="CC">CC</div>
                <div class="F">F</div>
                <div class="E">E</div>
                <div class="PV">PV</div>
                <div class="I">I</div>
                <div class="A">A</div>
                <div class="CD">CD</div>
                </div>
                
                <div class="container_crt">
            <div class="c1">${selected_unit}</div>
                <div class="c2">4</div>
                <div class="c3">4</div>
                <div class="c4">4</div>
                <div class="c5">1</div>
                <div class="c6">4</div>
                <div class="c7">2</div>
                <div class="c8">9</div>
                </div>
                
                <div class="container_weapon">
                <div class="armes">Equipement: ${selected_weapon}, ${selected_armor}</div>
            </div>
            <div class="container_options">
                <div class="options">Options: musicien, étendard, chef</div>
            </div>
            <div class="container_object">
                <div class="object">Objets:</div>
            </div>
            <a class="remove_unit">Delete</a>
                </div>`);

            refresh_delete_links();
            refresh_total_cost();
            refresh_army_cost();
        })
    })
}

/* Récupère et affiche les armes en fonction de l'unité choisie */
function get_weapon_options(){
    const selected_unit = document.getElementById("select_unit").value;
    const data = {
        select_unit: selected_unit
    };
    $.ajax({
        url: 'weapon_select.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success : (function (data) {
            nb_requete_terminees++;
            refresh_unit_select();

            // Réinitialisation des armes à zéro
            $('#select_weapon>option').remove();
            
            for (let i = 0; i < data.length; i++) {
                const optionHtml = `<option class="weapon" value="${data[i]["weapon"]}">${data[i]["weapon"]}</option>`;
                $(weapon_input).append(optionHtml);
            }
            refresh_weapon_cost();
            refresh_total_cost();
        }),
        error : function(result, statut, erreur){
            console.log('Erreur lors de la récupération des armes');
            console.log(result);
            console.log(statut);
            console.log(erreur);
        }
    });
}

/* Récupère et affiche les armures en fonction de l'unité choisie */
function get_armor_options(){
    const selected_unit = document.getElementById("select_unit").value;
    const data = {
        select_unit: selected_unit
    };

    $.ajax({
        url: 'armor_select.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: (function (data) {
            nb_requete_terminees++;
            refresh_unit_select();

            // Réinitialisation des armures à zéro
            $('#select_armor>option').remove();

            for (let i = 0; i < data.length; i++) {
                const optionHtml = `<option class="armor" value="${data[i]["armor"]}">${data[i]["armor"]}</option>`;
                $(input_armor).append(optionHtml);
            }
            refresh_armor_cost();
            refresh_total_cost();
        }),
        error: function (result, statut, erreur) {
            console.log('Erreur lors de la récupération des armures');
            console.log(result);
            console.log(statut);
            console.log(erreur);
        }
    });
}

/* Rafraichit le cout d'une unité lors de la selection d'une unité */
function refresh_unit_value(){
    // Desactivation du champ de selection d'unité en attendant que toutes les requêtes soient terminées
    nb_requete_terminees = 0;
    refresh_unit_select();

    const selected_unit = document.getElementById("select_unit").value;
    const data = {
        select_unit: selected_unit
    };
    $.ajax({
        url: 'unit_value.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: (function (data) {
            nb_requete_terminees++;
            refresh_unit_select();

            for (let i = 0; i < data.length; i++) {
                const unit_value = data[i]["cost"];
                $("#input_unit_cost").val(unit_value);
            }
            get_armor_options();
            get_weapon_options();
            refresh_total_cost();
        })
    });
}

/* Rafraichit le cout de l'arme qui vient d'être selectionnée */
function refresh_weapon_cost(){
    const selected_weapon = document.getElementById("select_weapon").value;
    const selected_unit = document.getElementById("select_unit").value;
    const data = {
        select_unit: selected_unit,
        select_weapon: selected_weapon
    };
    console.log('[refresh_weapon_cost] Data send :');
    console.log(data);
    $.ajax({
        url: 'weapon_value.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: (function (data) {
            nb_requete_terminees++;
            refresh_unit_select();

            console.log('[refresh_weapon_cost] Data received :');
            console.log(data);
            for (let i = 0; i < data.length; i++) {
                const weapon_cost = data[i]["weapon_cost"];
                $("#input_weapon_cost").val(weapon_cost);
            }
            refresh_total_cost();
        }),
        error : function(result, statut, erreur){
            console.log('Erreur lors du cout de l\'arme');
            console.log(result);
            console.log(statut);
            console.log(erreur);
        }
    });
}

/* Rafraichit le cout de l'armure qui vient d'être selectionnée */
function refresh_armor_cost(){
    const selected_unit = document.getElementById("select_unit").value;
    const selected_armor = document.getElementById("select_armor").value;
    const data = {
        select_unit: selected_unit,
        select_armor: selected_armor
    };
    console.log('[refresh_armor_cost] Data send :');
    console.log(data);

    $.ajax({
        url: 'armor_value.php',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: (function (data) {
            nb_requete_terminees++;
            refresh_unit_select();

            console.log('[refresh_armor_cost] Data received :');
            console.log(data);
            for (let i = 0; i < data.length; i++) {
                const armor_cost = data[i]["armor_cost"];
                $("#input_armor_cost").val(armor_cost);
            }
            refresh_total_cost();
        }),
        error : function(result, statut, erreur){
            console.log('Erreur lors de la récupération du cout de l\'armure');
            console.log(result);
            console.log(statut);
            console.log(erreur);
        }
    });
}

$("#select_unit").change(function () {
    refresh_unit_value();
});

$("#select_weapon").change(function () {
    refresh_weapon_cost();
});

$("#select_armor").change(function () {
    refresh_armor_cost();
});

$("#add_button").click(function () {
    insert_unit();
})

$("#input_unit_multiply").bind('input',function() {
    $('#input_unit_multiply').val();
    refresh_total_cost();
});


/* Méthode pour calculer le cout total de l'ajout en cours */
function refresh_total_cost(){
    const unit_cost = $('#input_unit_cost').val();
    console.log(unit_cost);
    const weapon_cost = $('#input_weapon_cost').val();
    console.log(weapon_cost);
    const armor_cost = $('#input_armor_cost').val();
    console.log(armor_cost);
    const cost = parseInt(unit_cost) + parseInt(weapon_cost) + parseInt(armor_cost);
    const nb_unit = $('#input_unit_multiply').val();
    const total_cost = parseInt(cost) * parseInt(nb_unit);
    console.log(total_cost);
    $('#input_calculator').val(total_cost);
}



/* Méthode pour calculer le cout total de la liste d'armée */
function refresh_army_cost(){
    const units = $("#army_list .total");
    let army_cost = 0;

    for(const unit of units){
        army_cost += parseInt(unit.value);
    }

    $('#total_army').html(` Total : ${army_cost} / 2000 pts` );
    var total =   $('#total_input_value').val(army_cost)

    var total_input = document.getElementById('total_input_value').value
    var limit = 2000

    console.log('limit :'+ limit);
    console.log('total :'+ total_input);

    if(total_input >= limit)
    {
        $('#total_army').css("color", "red")
    }
    else {
        $('#total_army').css("color", "black")
    }
}




$(document).ready(function () {
    refresh_delete_links();
    refresh_unit_value();
    refresh_army_cost();
});


$(document).ready(function () {
/* Update le titre */
$('#input_title').keypress(function(event) {

    const input_title = document.getElementById("input_title").value;

    console.log('[title] Data send :');
    console.log(input_title);

    console.log('[id_sheet_prim] Data send :');
    console.log(id_input_hidden);


    if (event.keyCode === 13) {
        $.ajax({
            url: 'update.php',
            type: 'POST',
            data: { id_sheet_prim: id_input_hidden, title: input_title },
            success: (function () {
                console.log('mise à jour effectuée');
            }),
            error : function(result, statut, erreur){
                console.log('Erreur update');
                console.log(result);
                console.log(statut);
                console.log(erreur);
            }
        })
    }
})
});