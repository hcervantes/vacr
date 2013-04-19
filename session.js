Ext.onReady(function() {

	Ext.ns('App');

	App.BTN_OK = 'ok';
	App.BTN_YES = 'yes';
	// 1 min. before notifying the user her session will expire. Change this to a reasonable interval.
	App.SESSION_ABOUT_TO_TIMEOUT_PROMT_INTERVAL_IN_MIN = 2;
	// 1 min. to kill the session after the user is notified.
	App.GRACE_PERIOD_BEFORE_EXPIRING_SESSION_IN_MIN = 1;
	// The page that kills the server-side session variables.
	App.SESSION_KILL_URL = 'auth/process.php?method=logout';
	// The url to process request
	App.SESSION_PROCESS_URL = 'auth/process.php';

	// Helper that converts minutes to milliseconds.
	App.toMilliseconds = function(minutes) {
		return minutes * 60 * 1000;
	}
	// Create a variable to hold our EXT Form Panel.
	// Assign various config options as seen.
	App.login = new Ext.FormPanel({
		labelWidth : 80,
		url : 'auth/process.php',
		frame : true,
		title : 'Please Login',
		defaultType : 'textfield',
		monitorValid : true,
		// Specific attributes for the text fields for username / password.
		// The "name" attribute defines the name of variables sent to the server.
		items : [{
			fieldLabel : 'Username',
			name : 'user',
			allowBlank : false
		}, {
			fieldLabel : 'Password',
			name : 'pass',
			inputType : 'password',
			allowBlank : false
		}, {
			xtype : 'checkboxfield',
			width : 150,
			fieldLabel : 'Remember me',
			name : 'remember'
		}, {
			xtype : 'hiddenfield',
			anchor : '100%',
			itemId : 'aircraftID',
			fieldLabel : 'Label',
			name : 'sublogin',
			value : 1
		}],

		// All the magic happens after the user clicks the button
		buttons : [{
			text : 'Login',
			formBind : true,
			// Function that fires when user clicks the button
			handler : function() {
				App.login.getForm().submit({
					method : 'POST',
					waitTitle : 'Connecting',
					waitMsg : 'Sending data...',

					// Functions that fire (success or failure) when the server responds.
					// The one that executes is determined by the
					// response that comes from login.asp as seen below. The server would
					// actually respond with valid JSON,
					// something like: response.write "{ success: true}" or
					// response.write "{ success: false, errors: { reason: 'Login failed. Try again.' }}"
					// depending on the logic contained within your server script.
					// If a success occurs, the user is notified with an alert messagebox,
					// and when they click "OK", they are redirected to whatever page
					// you define as redirect.

					success : function() {
						App.loginWin.hide();
					},

					// Failure function, see comment above re: success and failure.
					// You can see here, if login fails, it throws a messagebox
					// at the user telling him / her as much.

					failure : function(form, action) {
						if (action.failureType == 'server') {
							var msg = action.result.errors.user;
							Ext.Msg.alert('Login Failed!', msg);
						} else {
							Ext.Msg.alert('Warning!', 'Authentication server is unreachable : ' + action.response.responseText);
						}
						App.login.getForm().reset();
					}
				});
			}
		}]
	});
	// This just creates a window to wrap the login form.
	// The login object is passed to the items collection.
	App.loginWin = new Ext.Window({
		layout : 'fit',
		modal : true,
		width : 300,
		height : 250,
		closable : false,
		resizable : false,
		plain : true,
		border : false,
		items : [App.login]
	});

	// Helper that simulates AJAX request.
	App.simulateAjaxRequest = function() {

		Ext.Ajax.request({
			url : App.SESSION_PROCESS_URL,
			success : Ext.emptyFn,
			failure : Ext.emptyFn
		});
	}
	// Helper that simulates request to kill server-side session variables.
	App.simulateAjaxRequestToKillServerSession = function() {

		Ext.Ajax.request({
			url : App.SESSION_KILL_URL,
			success : Ext.emptyFn,
			failure : Ext.emptyFn
		});
	}
	// Get whether user is logged in or not
	App.checkUserLoggedIn = function() {
		Ext.Ajax.request({
			url : App.SESSION_PROCESS_URL,
			params : {
				'userAccess' : '1'
			},
			method : 'POST',
			success : function(response) {
				var obj = Ext.decode(response.responseText);
				if (!obj.userAccount.isLoggedIn) {
					App.loginWin.show();

				}
			},
			failure : function(response) {
				return false;
			}
		});
	}
	// Notifies user that her session is about to time out.
	App.sessionAboutToTimeoutPromptTask = new Ext.util.DelayedTask(function() {
		// If login window is showing, exit
		if(!App.loginWin.isHidden())
		{
			return;
		}
		console.log('sessionAboutToTimeoutPromptTask');

		Ext.Msg.confirm('Your Session is About to Expire', 'Your session will expire in ' + App.GRACE_PERIOD_BEFORE_EXPIRING_SESSION_IN_MIN + ' minute(s). Would you like to continue your session?', function(btn, text) {

			if (btn == App.BTN_YES) {
				// Simulate resetting the server-side session timeout timer
				// by sending an AJAX request.
				App.simulateAjaxRequest();
			} else {
				// Send request to kill server-side session.
				App.simulateAjaxRequestToKillServerSession();
				
			}
		});

		App.killSessionTask.delay(App.toMilliseconds(App.GRACE_PERIOD_BEFORE_EXPIRING_SESSION_IN_MIN));
	});

	// Schedules a request to kill server-side session.
	App.killSessionTask = new Ext.util.DelayedTask(function() {
		console.log('killSessionTask');
		App.simulateAjaxRequestToKillServerSession();
	});

	// Starts the session timeout workflow after an AJAX request completes.
	Ext.Ajax.on('requestcomplete', function(conn, response, options) {
		// If login window is showing, exit
		if(!App.loginWin.isHidden())
		{
			return;
		}
		if (options.url !== App.SESSION_KILL_URL) {
			// Reset the client-side session timeout timers.
			// Note that you must not reset if the request was to kill the server-side session.
			App.sessionAboutToTimeoutPromptTask.delay(App.toMilliseconds(App.SESSION_ABOUT_TO_TIMEOUT_PROMT_INTERVAL_IN_MIN));
			App.killSessionTask.cancel();
		} else {
			// Notify user her session timed out.
			Ext.Msg.alert('Session Expired', 'Your session expired. Please login to start a new session.', function(btn, text) {

				if (btn == App.BTN_OK) {
					App.loginWin.show();
					// TODO: Show logon form here.
				}
			});
		}
	});

	// The rest of your app's code would go here. I will just simulate
	// an AJAX request so the session timeout workflow gets started.
	App.simulateAjaxRequest();
});
