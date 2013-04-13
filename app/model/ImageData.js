/*
 * File: app/model/ImageData.js
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

Ext.define('VACR.model.ImageData', {
    extend: 'Ext.data.Model',

    idProperty: 'ID',

    fields: [
        {
            name: 'PICTURE'
        },
        {
            name: 'ID'
        },
        {
            name: 'AIRCRAFT_ID'
        }
    ],

    proxy: {
        type: 'ajax',
        actionMethods: 'POST',
        api: {
            read: 'listPictures.php',
            create: 'savePictures.php.php',
            destroy: 'deletePicture.php'
        },
        writer: {
            type: 'json',
            allowSingle: false,
            root: 'data'
        }
    }
});