<?php
if (!isConnect('admin')) {
    throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'ozw672');
$eqLogics = eqLogic::byType('ozw672');
?>

<div class="row row-overflow">
	<div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter une ozw672}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
               <?php
                foreach ($eqLogics as $eqLogic) {
                    echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName(true) . '</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>

    <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
	  <legend><i class="fa fa-cog"></i>  {{Gestion}}</legend>
	   <div class="eqLogicThumbnailContainer">
		<div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
		 <center>
		  <i class="fa fa-plus-circle" style="font-size : 6em;color:#94ca02;"></i>
		</center>
		<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
	  </div>
	  <div class="cursor eqLogicAction" data-action="gotoPluginConf" style="background-color : #ffffff; height : 120px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;">
		<center>
		  <i class="fa fa-wrench" style="font-size : 6em;color:#767676;"></i>
		</center>
		<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#767676"><center>{{Configuration}}</center></span>
	  </div>
	</div>
        <legend>{{Mes Ozw672}}
        </legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
				<center>
				<i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
				</center>
				<span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
			</div>
			<?php
			if (count($eqLogics) == 0) {
				echo "<br/><br/><br/><center><span style='color:#767676;font-size:1.2em;font-weight: bold;'>{{Vous n'avez pas encore de ozw672, cliquez sur Ajouter un équipement pour commencer}}</span></center>";
			} else {
                foreach ($eqLogics as $eqLogic) {
                    echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
                    echo "<center>";
                    echo '<img src="plugins/ozw672/plugin_info/ozw672_icon.png" height="105" width="95" />';
                    echo "</center>";
                    echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
                    echo '</div>';
                }
			}
			?>
		</div>
    </div>
    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
		<a class="btn btn-success eqLogicAction pull-right" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
		<a class="btn btn-danger eqLogicAction pull-right" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
		<a class="btn btn-default eqLogicAction pull-right" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-tachometer"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
		</ul>
		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<form class="form-horizontal">
					<fieldset>
						<legend>
						   <i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}
						   <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i>
					   </legend>
						<div class="form-group">
							<label class="col-lg-2 control-label">{{Nom de l'ozw672}}</label>
							<div class="col-lg-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
								<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'ozw672}}"/>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label" >{{Objet parent}}</label>
							<div class="col-lg-3">
								<select class="form-control eqLogicAttr" data-l1key="object_id">
									<option value="">{{Aucun}}</option>
									<?php
									foreach (jeeObject::all() as $object) {
										echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>'."\n";
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 control-label">{{Catégorie}}</label>
							<div class="col-lg-8">
								<?php
								foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
									echo '<label class="checkbox-inline">'."\n";
									echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
									echo '</label>'."\n";
								}
								?>

							</div>
						</div>
						<div class="form-group">
						  <label class="col-sm-2 control-label" ></label>
							<div class="col-sm-10">
							<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Activer}}" data-l1key="isEnable" checked/>Activer</label>
							<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-label-text="{{Visible}}" data-l1key="isVisible" checked/>Visible</label>
							<a class="btn btn-default carte_only" id="bt_goCarte" title='{{Accéder à la carte}}'><i class="fa fa-cogs"> {{Accéder à la carte}}</i></a>
							<a class="btn btn-default carte_only" id="bt_ScanCarte" title='{{Detecter appareil}}'><i class="fa fa-refresh"> {{Détecter les sous-cartes}}</i></a>
							<a class="btn btn-default nocarte_only" id="bt_ScanCarteCommande" title='{{Detecter les commandes principales}}'><i class="fa fa-refresh"> {{Detecter les commandes principales}}</i></a>
							<a class="btn btn-default nocarte_only" id="bt_ScanCarteAllCommande" title='{{Detecter toutes les commandes}}'><i class="fa fa-refresh"> {{Detecter toutes les commandes}}</i></a>
						  </div>
						</div>
						<div class="form-group carte_only">
							<label class="col-lg-2 control-label">{{IP de l'ozw672}}</label>
							<div class="col-lg-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="ip"/>
							</div>
						</div>
						<div class="form-group carte_only">
							<label class="col-lg-2 control-label">{{Compte de l'ozw672}}</label>
							<div class="col-lg-3">
								<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="username"/>
							</div>
						</div>
						<div class="form-group carte_only">
							<label class="col-lg-2 control-label">{{Password de l'ozw672}}</label>
							<div class="col-lg-3">
								<input type="password" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="password"/>
							</div>
						</div>
					</fieldset> 
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="commandtab">
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th style="width: 50px;">#</th>
							<th>{{Nom}}</th>
							<th style="width: 120px;">{{Icône-action}}</th>
							<th style="width: 120px;">{{Sous-Type}}</th>
							<th style="width: 120px;">{{Paramètres}}</th>
							<th style="width: 100px;">{{Action}}</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>

<?php
include_file('desktop', 'ozw672', 'js', 'ozw672');
include_file('core', 'plugin.template', 'js');
?>
