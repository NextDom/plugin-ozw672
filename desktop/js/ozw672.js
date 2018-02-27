function addCmdToTable(_cmd) {
   if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }
    if (!isset(_cmd.configuration)) {
        _cmd.configuration = {};
    }

    if (init(_cmd.type) == 'info') {
        var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '" >';
        tr += '<td>';
        tr += '<span class="cmdAttr" data-l1key="id"></span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom}}"></td>';
		tr += '</td>';
		tr += '<td>';
        tr += '</td>';
		tr += '<td>';
        tr += '<input class="cmdAttr form-control type input-sm" data-l1key="type" value="info" disabled style="margin-bottom : 5px;" />';
        tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
		tr += '<input type=hidden class="cmdAttr form-control input-sm" data-l1key="unite" value="">';
        tr += '</td>';
        tr += '<td>';
		tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="configuration" data-l2key="isCollected" value="1"/> {{Collecter}}<br/></span>';
		tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isHistorized"/> {{Historiser}}<br/></span>';
        tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/> {{Afficher}}<br/></span>';
        tr += '</td>';
        tr += '<td>';
		tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';		
        if (is_numeric(_cmd.id)) {
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
        }
        tr += '</td>';
		table_cmd = '#table_cmd';
		if ( $(table_cmd+'_'+_cmd.eqType ).length ) {
			table_cmd+= '_'+_cmd.eqType;
		}
        $(table_cmd+' tbody').append(tr);
        $(table_cmd+' tbody tr:last').setValues(_cmd, '.cmdAttr');
    }
    if (init(_cmd.type) == 'action') {
        var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
        tr += '<td>';
        tr += '<span class="cmdAttr" data-l1key="id"></span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom}}">';
		tr += '</td>';
        tr += '<td>';
		tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fa fa-flag"></i> Icone</a>';
		tr += '<span class="cmdAttr cmdAction" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<input class="cmdAttr form-control type input-sm" data-l1key="type" value="action" disabled style="margin-bottom : 5px;" />';
        tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
        tr += '</td>';
        tr += '<td>';
        tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/> {{Afficher}}<br/></span>';
        tr += '</td>';
        tr += '<td>';
		tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';		
        if (is_numeric(_cmd.id)) {
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
            tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
        }
//		tr += '<td><i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
		tr += '</tr>';

		table_cmd = '#table_cmd';
		if ( $(table_cmd+'_'+_cmd.eqType ).length ) {
			table_cmd+= '_'+_cmd.eqType;
		}
        $(table_cmd+' tbody').append(tr);
        $(table_cmd+' tbody tr:last').setValues(_cmd, '.cmdAttr');
        var tr = $(table_cmd+' tbody tr:last');
        jeedom.eqLogic.builSelectCmd({
            id: $(".li_eqLogic.active").attr('data-eqLogic_id'),
            filter: {type: 'info'},
            error: function (error) {
                $('#div_alert').showAlert({message: error.message, level: 'danger'});
            },
            success: function (result) {
                tr.find('.cmdAttr[data-l1key=value]').append(result);
                tr.setValues(_cmd, '.cmdAttr');
            }
        });
    }
}

function printEqLogic(_eqLogic) {
	if ( _eqLogic.configuration.type == 'ozw672' )
	{
		$('.carte_only').show();
		$('.nocarte_only').hide();
	}
	else
	{
		$('.carte_only').hide();
		$('.nocarte_only').show();
	}
}

$('#bt_goCarte').on('click', function() {
    $('#md_modal').dialog({title: "{{Accèder à l'interface de la ozw672}}"});
	window.open('http://'+$('.eqLogicAttr[data-l2key=ip]').value()+'/');
});

$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

$('#bt_ScanCarte').on('click', function() {
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/ozw672/core/ajax/ozw672.ajax.php", // url du fichier php
        data: {
            action: "force_detect_carte",
			id: $(".li_eqLogic.active").attr('data-eqLogic_id'),
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, $('#div_DetectBin'));
        },
        success: function(data) { // si l'appel a bien fonctionné
			if (data.state != 'ok') {
				$('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
			}
			window.location.reload();
		}
    });
});

$('#bt_ScanCarteCommande').on('click', function() {
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/ozw672/core/ajax/ozw672.ajax.php", // url du fichier php
        data: {
            action: "force_detect_commande_carte",
			id: $(".li_eqLogic.active").attr('data-eqLogic_id'),
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, $('#div_DetectBin'));
        },
        success: function(data) { // si l'appel a bien fonctionné
			if (data.state != 'ok') {
				$('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
			}
			window.location.reload();
		}
    });
});

$('#bt_ScanCarteAllCommande').on('click', function() {
    $.ajax({// fonction permettant de faire de l'ajax
        type: "POST", // methode de transmission des données au fichier php
        url: "plugins/ozw672/core/ajax/ozw672.ajax.php", // url du fichier php
        data: {
            action: "force_detect_all_commande_carte",
			id: $(".li_eqLogic.active").attr('data-eqLogic_id'),
        },
        dataType: 'json',
        error: function(request, status, error) {
            handleAjaxError(request, status, $('#div_DetectBin'));
        },
        success: function(data) { // si l'appel a bien fonctionné
			if (data.state != 'ok') {
				$('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
			}
			window.location.reload();
		}
    });
});

