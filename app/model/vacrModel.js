/*
 * File: app/model/vacrModel.js
 *
 * This file was generated by Sencha Architect version 2.2.0.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 4.1.x library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 4.1.x. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('VACR.model.vacrModel', {
    extend: 'Ext.data.Model',

    fields: [
        {
            name: 'id'
        },
        {
            name: 'name'
        },
        {
            name: 'modelno'
        }
    ],

    proxy: {
        type: 'ajax',
        actionMethods: 'POST',
        api: {
            read: 'listVacr.php',
            create: 'saveVacr.php',
            update: 'saveVacr.php',
            destroy: 'deleteVacr.php'
        },
        reader: {
            type: 'json',
            messageProperty: 'message',
            root: 'data'
        },
        writer: {
            type: 'json',
            allowSingle: false,
            root: 'data'
        }
    }
});