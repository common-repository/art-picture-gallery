	<div>
        <input type="hidden" id="loaded_template" value="">
		<h2 class="warn"><span class="fa fa-gears"></span> Email <small>Settings</small></h2>
        <br />
        <button role="button"class="btn btn-primary btn-outline"data-toggle="modal" data-target="#newMailVorlageModal"><span class="fa fa-plus-square"></span> neue eMail Vorlage </button>
	    <br /><br />
        <div id="email_links"></div>
       <h4 class="warn"><span class="fa fa-envelope-o"></span> eMail <small id="loaded">Userdaten</small></h4>

       <br />
       <p>
		<b class="warn"><span class="fa fa-thumb-tack"></span><span class="grey"> Platzhalter:</span></b>&nbsp;&nbsp;
        <span style="color: #337ab7;">[loginurl]</span>&nbsp;&nbsp;
        <span style="color: #337ab7;">[vorname]</span>&nbsp;&nbsp;
        <span style="color: #337ab7;">[nachname]</span>&nbsp;&nbsp;
        <span style="color: #337ab7;">[loginname]</span>&nbsp;&nbsp;
        <span style="color: #337ab7;">[passwort]</span>&nbsp;&nbsp;

		</p>
        <br />
        <hr class="hr-light">
        <p><span class="prem fa fa-info-circle "></span><b class="prem"> INFO:</b><b class="grey"> Der Platzhalter [passwort] ist nur in der <u>zugangsdaten eMail</u> aktiv.</b> </p>
      
        <hr class="hr-light">
        <br>
      <div>
    <textarea id="elm1" name="elm1" rows="65" cols="140" style="width: 100%">
    </textarea>
	</div>
	<br />
       <div class="btn-group">
      <a role="button"class="btn btn-success btn-outline" onclick="save_user_email_template(tinyMCE.get('elm1').getContent());return false;"><span class="fa fa-save"></span> speichern</a>
        <button role="button" class="btn btn-danger btn-outline" role="button" onclick="delete_email_template();"><span class="dan fa fa-trash"></span> Vorlage l&ouml;schen </button>       
        </div>
	</div>
