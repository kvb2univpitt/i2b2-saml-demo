/**
 * @projectDescription	PM helper functions and Misc code.
 * @inherits 	i2b2
 * @namespace	i2b2
 * @author		Nick Benik, Griffin Weber MD PhD
 * @version 	1.3
 * ----------------------------------------------------------------------------------------
 * updated 9-15-08: RC4 launch [Nick Benik] 
 */
console.group('Load & Execute component file: cells > PM > misc');
console.time('execute time');


// helper functions in the object scope
// ================================================================================================== //
i2b2.h.getUser = function () {
    return i2b2.PM.model.login_username;
}
i2b2.h.getFullname = function () {
    return i2b2.PM.model.login_fullname;
}
i2b2.h.getPass = function () {
    return i2b2.PM.model.login_password;
}
i2b2.h.getDomain = function () {
    return i2b2.PM.model.login_domain;
}
i2b2.h.getProxy = function () {
    return i2b2.hive.cfg.urlProxy;
}
i2b2.h.getProject = function () {
    return i2b2.PM.model.login_project;
}
i2b2.h.isSHRINE = function () {
    return i2b2.PM.model.shrine_domain;
}
i2b2.h.inDebugMode = function () {
    return i2b2.PM.model.login_debugging;
}
i2b2.h.allowAnalysis = function () {
    return i2b2.PM.model.allow_analysis;
}
i2b2.h.adminOnly = function () {
    return i2b2.PM.model.admin_only;
}

i2b2.PM.model.login_username = '';
i2b2.PM.model.login_fullname = '';
i2b2.PM.model.login_password = '';
i2b2.PM.model.login_projectname = '';
i2b2.PM.model.login_domain = '';
i2b2.PM.model.shrine_domain = false;
i2b2.PM.model.admin_only = false;
i2b2.PM.model.Domains = i2b2.hive.cfg.lstDomains;
i2b2.PM.model.reLogin = false;
i2b2.PM.model.IdleTimer = YAHOO.util.IdleTimer;


i2b2.PM.model.IdleTimer.subscribe("idle", function () {

    //if (!i2b2.PM.model.IdleTimer.dialogTimeout) {	
    i2b2.PM.model.reLogin = true;


    //	i2b2.h.LoadingMask.show();
    //	i2b2.PM.doLoginDialog();


    /*
     var r=confirm("Your session will automatically time out in 5 minutes due to inactivity.  Please click \"OK\" to continue your session, or click cancel to log out.");
     if (r==true)
     {
     i2b2.PM.model.IdleTimer.stop();
     i2b2.PM.udlogin.inputPass.value = i2b2.PM.model.login_password.substring(i2b2.PM.model.login_password.indexOf(">")+1,i2b2.PM.model.login_password.lastIndexOf("<") );
     
     i2b2.h.LoadingMask.show();
     
     i2b2.PM.doLogin();			  
     }
     else
     {
     i2b2.PM.doLogout();
     }
     
     */


    var handleCancel = function () {
        i2b2.PM.doLogout();
    };
    var loopBackSubmit = function () {
        i2b2.PM.model.IdleTimer.stop();
        i2b2.PM.udlogin.inputPass.value = i2b2.PM.model.login_password.substring(i2b2.PM.model.login_password.indexOf(">") + 1, i2b2.PM.model.login_password.lastIndexOf("<"));

        i2b2.h.LoadingMask.show();

        i2b2.PM.doLogin();
        i2b2.PM.model.dialogTimeout.hide();
        i2b2.h.LoadingMask.hide();
    };
    i2b2.PM.model.dialogTimeout = new YAHOO.widget.SimpleDialog("dialogTimeout", {
        width: "400px",
        fixedcenter: true,
        constraintoviewport: true,
        modal: true,
        zindex: 700,
        buttons: [{
                text: "OK",
                handler: loopBackSubmit,
                isDefault: true
            }, {
                text: "Logout",
                handler: handleCancel
            }]
    });
    $('dialogTimeout').show()
    i2b2.PM.model.dialogTimeout.render(document.body);

    i2b2.PM.model.dialogTimeout.show();




    //var idleTimer = YAHOO.util.IdleTimer;
    //	i2b2.PM.model.WarnTimer.start(10000);




});


// login screen
// ================================================================================================== //
i2b2.PM.model.html = {};
i2b2.PM.model.html.loginDialog = `
<div id="i2b2_login_modal_dialog" style="display:block;">
    <div class="hd">${i2b2.UI.cfg.loginHeaderText}</div>
    <div class="login-dialog">
        <div class="row py-3 px-3" id="error_msg" style="display: ${error_msg.length > 0 ? 'block' : 'none'};">
            <div class="col-12">
                <div class="alert alert-danger" role="alert"><h6>${error_msg}</h6></div>
            </div>
        </div>
        <div class="row py-3 px-3" id="success_msg" style="display: ${success_msg.length > 0 ? 'block' : 'none'};">
            <div class="col-12">
                <div class="alert alert-success" role="alert"><h6>${success_msg}</h6></div>
            </div>
        </div>
        <div class="row py-3 px-3">
            <div class="col-6">
                <h6>Sign In</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="alert alert-danger" id="loginMessage" role="alert">Login incorrect or host not found.</div>
                        <div class="d-grid gap-2 col-12 mx-auto">
                            <button class="btn btn-sm btn-primary" type="button" onclick="location.href='login.php';">Sign In With ${i2b2.UI.cfg.loginIdpAccount}</button>
                        </div>
                        <p class="divider-text"><span class="bg-light">OR</span></p>
                        <form name="loginForm" style="margin:0;padding:0;" onsubmit="i2b2.PM.doLogin(); return false;">
                            <div class="mb-3">
                                <label for="loginusr" class="form-label fw-bold">${i2b2.UI.cfg.loginUsernameText}</label>
                                <input class="form-control form-control-sm" type="text" type="text" name="uname" id="loginusr" value="${i2b2.UI.cfg.loginDefaultUsername}" size="20" maxlength="50" />
                            </div>
                            <div class="mb-3">
                                <label for="loginpass" class="form-label fw-bold">${i2b2.UI.cfg.loginPasswordText}</label>
                                <input class="form-control form-control-sm" type="password" name="pword" id="loginpass" value="${i2b2.UI.cfg.loginDefaultPassword}" size="20" maxlength="50" />
                            </div>
                            <div class="mb-3">
                                <label for="logindomain" class="form-label fw-bold">${i2b2.UI.cfg.loginHostText}</label>
                                <select class="form-select form-select-sm" name="server" id="logindomain">
                                    <option value="">Loading...</option>
                                </select>
                            </div>
                            <div class="d-grid gap-2 col-12 mx-auto">
                                <button class="btn btn-sm btn-primary" type="button" id="loginButton" onclick="i2b2.PM.doLogin()">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <h6>Sign Up</h6>
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3">
                            <textarea class="w-100" rows="16" readonly="readonly">${i2b2.UI.cfg.termsCondition}</textarea>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="agree" onchange="handleAgreeChbx(this);">
                            <label class="form-check-label" for="agree">I accept the Terms & Conditions</label>
                        </div>
                        <div class="d-grid gap-2 col-12 mx-auto">
                            <button class="btn btn-sm btn-success" id="register_btn" type="button" onclick="location.href='registration/user/';" disabled="disabled">Register via ${i2b2.UI.cfg.loginIdpAccount}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
`;

// project selection screen
i2b2.PM.model.html.projDialog = '<div id="i2b2_projects_modal_dialog" style="display:block;">\n' +
        '	<div class="hd" style="background:#6677AA;">Choose a Project</div>\n' +
        '	<div class="bd">\n' +
        '	<form onsubmit="i2b2.PM.selectProject(); return false;" style="margin: 0pt; padding: 0pt;" name="projectsForm">\n' +
        '		<div style="text-align:right">\n' +
        '			<div style="float:left; padding-top:3px"><B>Project:</B></div>\n' +
        '			<div style="float:left; margin-left:5px"><select id="loginProjs" name="projects" onchange="i2b2.PM.view.modal.projectDialog.renderDetails()"><option value="">Loading...</option></select></div>\n' +
        '			<input type="button" value="     Go     " onclick="i2b2.PM.view.modal.projectDialog.loadProject()"/>\n' +
        '		</div>\n' +
        '		<div id="projectAttribs">\n' +
        '			<div>\n' +
        '				<div style="float:left; width:120px; background:#DDF; padding-left:4px; border-bottom:1px solid #bbb">test</div>\n' +
        '				<div style="float:right; padding-left:6px; width:248px; border-bottom:1px solid #ddd">this tis the test description</div>\n' +
        '			</div>\n' +
        '			<div>\n' +
        '				<div style="float:left; width:120px; background:#DDF; padding-left:4px; border-bottom:1px solid #bbb">test</div>\n' +
        '				<div style="float:right; padding-left:6px; width:248px; border-bottom:1px solid #ddd">this tis the test description</div>\n' +
        '			</div>\n' +
        '			<div style="clear:both; display:none"></div>\n' +
        '		</div>\n' +
        '		<div id="projDetailRec-CLONE" style="display:none">\n' +
        '			<div class="name" >test</div>\n' +
        '			<div class="value">this tis the test description</div>\n' +
        '		</div>\n' +
        '	</form>\n' +
        '	</div>\n' +
        '</div>\n';




i2b2.PM.model.html.announceDialog = '<div id="i2b2_announcement_modal_dialog" style="display:block;">\n' +
        '	<div class="hd" style="background:#6677AA;">Project Announcements</div>\n' +
        '	<div class="bd">\n' +
        '	<form onsubmit="i2b2.PM.selectProject(); return false;" style="margin: 0pt; padding: 0pt;" name="projectsForm">\n' +
        '		<div style="text-align:right">\n' +
        '			<div style="float:left; padding-top:3px"><B>Project:</B></div>\n' +
        '			<div style="float:left; margin-left:5px"><select id="loginProjs" name="projects" onchange="i2b2.PM.view.modal.projectDialog.renderDetails()"><option value="">Loading...</option></select></div>\n' +
        '			<input type="button" value="     Go     " onclick="i2b2.PM.view.modal.projectDialog.loadProject()"/>\n' +
        '		</div>\n' +
        '		<div id="projectAttribs">\n' +
        '			<div>\n' +
        '				<div style="float:left; width:120px; background:#DDF; padding-left:4px; border-bottom:1px solid #bbb">test</div>\n' +
        '				<div style="float:right; padding-left:6px; width:248px; border-bottom:1px solid #ddd">this tis the test description</div>\n' +
        '			</div>\n' +
        '			<div>\n' +
        '				<div style="float:left; width:120px; background:#DDF; padding-left:4px; border-bottom:1px solid #bbb">test</div>\n' +
        '				<div style="float:right; padding-left:6px; width:248px; border-bottom:1px solid #ddd">this tis the test description</div>\n' +
        '			</div>\n' +
        '			<div style="clear:both; display:none"></div>\n' +
        '		</div>\n' +
        '		<div id="projDetailRec-CLONE" style="display:none">\n' +
        '			<div class="name" >test</div>\n' +
        '			<div class="value">this tis the test description</div>\n' +
        '		</div>\n' +
        '	</form>\n' +
        '	</div>\n' +
        '</div>\n';



console.timeEnd('execute time');
console.groupEnd();