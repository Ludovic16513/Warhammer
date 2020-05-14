/* Divs / Containers */
const weapon_input = document.getElementById('select_weapon');
const input_armor = document.getElementById('select_armor');
const id_input_hidden = document.getElementById('input_id').value;

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
        // dataType: 'html',
        success:(function (data_id){
            $('#army_list').append(
                `<div class="unit">
                    <input id="unit_id" type="hidden" value="${data_id}">
                    <div>${selected_unit}</div>
                    <div>${selected_weapon}</div>
                    <div>${selected_armor}</div>
                    <div>${amount}</div>
                    <input class="total" value="${cost}"> 
                    <label for="">id</label>
                    <a class="remove_unit">Delete</a>
                </div>`
            );
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
    $('#total_army').val(army_cost);
}

$(document).ready(function () {
    refresh_delete_links();
    refresh_unit_value();
    refresh_army_cost();
});