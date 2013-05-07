/*
 * File: app/view/MyContainer.js
 *
 * This file was generated by Sencha Architect version 2.2.2.
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

Ext.define('VACR.view.MyContainer', {
    extend: 'Ext.container.Container',

    requires: [
        'VACR.view.adminPanel',
        'VACR.view.Globals'
    ],

    height: 612,
    width: 800,
    layout: {
        align: 'stretch',
        type: 'vbox'
    },

    initComponent: function() {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'panel',
                    flex: 1,
                    margins: '5',
                    frame: true,
                    height: 65,
                    id: 'headerPanel',
                    itemId: 'headerPanel',
                    layout: {
                        type: 'column'
                    },
                    items: [
                        {
                            xtype: 'label',
                            id: 'welcomeLabel',
                            itemId: 'welcomeLabel'
                        }
                    ]
                },
                {
                    xtype: 'panel',
                    height: 560,
                    width: 800,
                    layout: {
                        type: 'accordion'
                    },
                    title: 'Visual Aircraft Recognition',
                    items: [
                        {
                            xtype: 'panel',
                            itemId: 'reviewPanel',
                            collapsed: false,
                            title: 'Review',
                            items: [
                                {
                                    xtype: 'form',
                                    height: 500,
                                    itemId: 'mainPanel',
                                    layout: {
                                        type: 'border'
                                    },
                                    collapsed: false,
                                    title: '',
                                    items: [
                                        {
                                            xtype: 'gridpanel',
                                            region: 'west',
                                            itemId: 'vacrGrid',
                                            store: 'listVacrStore',
                                            listeners: {
                                                select: {
                                                    fn: me.onVacrGridSelect,
                                                    scope: me
                                                }
                                            },
                                            columns: [
                                                {
                                                    xtype: 'gridcolumn',
                                                    dataIndex: 'NAME',
                                                    text: 'NAME'
                                                },
                                                {
                                                    xtype: 'gridcolumn',
                                                    dataIndex: 'MODELNO',
                                                    text: 'MODELNO'
                                                }
                                            ]
                                        },
                                        {
                                            xtype: 'panel',
                                            region: 'center',
                                            itemId: 'bottomPanel',
                                            layout: {
                                                type: 'vbox'
                                            },
                                            title: 'Aircraft Detail',
                                            items: [
                                                {
                                                    xtype: 'panel',
                                                    id: 'detailPanel',
                                                    itemId: 'detailPanel',
                                                    tpl: [
                                                        '<b>Name: {NAME}</b><br>',
                                                        '<b><i>Model: {MODELNO}</i></b><br>',
                                                        ''
                                                    ],
                                                    layout: {
                                                        type: 'fit'
                                                    }
                                                },
                                                {
                                                    xtype: 'panel',
                                                    flex: 1,
                                                    layout: {
                                                        align: 'stretch',
                                                        type: 'hbox'
                                                    },
                                                    items: [
                                                        {
                                                            xtype: 'panel',
                                                            border: 1,
                                                            frame: true,
                                                            height: 450,
                                                            width: 230,
                                                            autoScroll: true,
                                                            items: [
                                                                {
                                                                    xtype: 'dataview',
                                                                    itemId: 'pictureView',
                                                                    autoScroll: true,
                                                                    itemSelector: 'div.thumb-wrap',
                                                                    itemTpl: [
                                                                        '<div style="margin-bottom: 10px;" class="thumb-wrap">',
                                                                        '    <img src="images/{PICTURE}" width="200" />',
                                                                        '</div>',
                                                                        '<b>Name: {PICTURE}</b><br>'
                                                                    ],
                                                                    store: 'pictureStore'
                                                                }
                                                            ]
                                                        },
                                                        {
                                                            xtype: 'panel',
                                                            itemId: 'descriptionPanel',
                                                            width: 300,
                                                            title: '',
                                                            items: [
                                                                {
                                                                    xtype: 'dataview',
                                                                    itemId: 'descriptionView',
                                                                    tpl: [
                                                                        '<ul>',
                                                                        '</ul>'
                                                                    ],
                                                                    itemSelector: 'div.thumb-wrap',
                                                                    itemTpl: [
                                                                        '<div style="margin-bottom: 10px;" class="thumb-wrap">',
                                                                        '    <li>{DESCRIPTION}</li>',
                                                                        '</div>'
                                                                    ],
                                                                    store: 'descriptionStore'
                                                                }
                                                            ]
                                                        }
                                                    ]
                                                }
                                            ]
                                        }
                                    ]
                                }
                            ]
                        },
                        {
                            xtype: 'panel',
                            itemId: 'practicePanel',
                            collapsed: false,
                            title: 'Practice Test',
                            items: [
                                {
                                    xtype: 'form',
                                    height: 500,
                                    autoScroll: true,
                                    layout: {
                                        type: 'hbox'
                                    },
                                    bodyPadding: 10,
                                    title: '',
                                    items: [
                                        {
                                            xtype: 'container',
                                            flex: 1,
                                            width: 312,
                                            layout: {
                                                type: 'column'
                                            },
                                            items: [
                                                {
                                                    xtype: 'combobox',
                                                    autoRender: true,
                                                    itemId: 'cmbChoice',
                                                    maxWidth: 300,
                                                    fieldLabel: 'Select correct choice',
                                                    labelWidth: 150,
                                                    autoSelect: false,
                                                    displayField: 'description',
                                                    queryMode: 'local',
                                                    store: 'choiceStore',
                                                    valueField: 'choice',
                                                    listeners: {
                                                        select: {
                                                            fn: me.onCmbChoiceSelect,
                                                            scope: me
                                                        }
                                                    }
                                                },
                                                {
                                                    xtype: 'button',
                                                    itemId: 'btnPrev',
                                                    text: '<- Previous',
                                                    listeners: {
                                                        click: {
                                                            fn: me.onBtnPrevClick,
                                                            scope: me
                                                        }
                                                    }
                                                },
                                                {
                                                    xtype: 'button',
                                                    itemId: 'btnNext',
                                                    text: 'Next ->',
                                                    listeners: {
                                                        click: {
                                                            fn: me.onBtnNextClick,
                                                            scope: me
                                                        }
                                                    }
                                                },
                                                {
                                                    xtype: 'button',
                                                    text: 'Check',
                                                    listeners: {
                                                        click: {
                                                            fn: me.onButtonClick,
                                                            scope: me
                                                        }
                                                    }
                                                }
                                            ]
                                        },
                                        {
                                            xtype: 'dataview',
                                            itemId: 'pictureQuizView',
                                            autoScroll: true,
                                            itemSelector: 'div.thumb-wrap',
                                            itemTpl: [
                                                '<div style="margin-bottom: 10px;" class="thumb-wrap">',
                                                '    <img src="images/{PICTURE}" width="200" />',
                                                '</div>'
                                            ],
                                            store: 'quizPictureStore'
                                        }
                                    ]
                                }
                            ],
                            listeners: {
                                expand: {
                                    fn: me.onPracticePanelExpand,
                                    scope: me
                                }
                            }
                        },
                        {
                            xtype: 'adminPanel',
                            hidden: true,
                            id: 'adminPanel'
                        }
                    ],
                    listeners: {
                        afterrender: {
                            fn: me.onPanelAfterRender,
                            scope: me
                        }
                    }
                }
            ],
            listeners: {
                afterlayout: {
                    fn: me.onContainerAfterLayout,
                    scope: me
                }
            }
        });

        me.callParent(arguments);
    },

    onVacrGridSelect: function(rowmodel, record, index, eOpts) {
        // grab a reference to the detailPanel via itemId
        // the # in front of the id indicates that we would like to grab a reference by
        var detailPanel = this.down('#detailPanel');
        // update the detailPanel with data
        // this will trigger the tpl to become updates
        detailPanel.update(record.data);
        // grab a reference to the pictureView, notice we use down here instead of child
        // because down will go down the container hierarchy at any depth and child will
        // only retrieve direct children
        var picView = this.down('#pictureView');
        // get the pictures field out of this record
        var picData = record.get('PICTURES');
        picView.store.loadData(picData);
        // get the descriptions field
        var descData = record.get('DESCRIPTIONS');
        var descView = this.down('#descriptionView');
        descView.store.loadData(descData);
    },

    onCmbChoiceSelect: function(combo, records, eOpts) {
        var quizData = Ext.data.StoreManager.lookup('quizDataStore');
        var record = quizData.getAt(VACR.view.Globals.currentRecord);
        record.selectedchoice = records[0].data.choice;
        // Do we need a store update? save?

    },

    onBtnPrevClick: function(button, e, eOpts) {
        var quizData = Ext.data.StoreManager.lookup('quizDataStore');
        //Check if at end
        if(VACR.view.Globals.currentRecord === 0)
        {
            //Reset current record
            VACR.view.Globals.currentRecord = quizData.getCount() - 1;    
        }
        else
        {
            //Increase current record
            --VACR.view.Globals.currentRecord;
        }

        VACR.view.Globals.doUpdate(this);
    },

    onBtnNextClick: function(button, e, eOpts) {
        var quizData = Ext.data.StoreManager.lookup('quizDataStore');
        //Check if at end
        if(VACR.view.Globals.currentRecord >= quizData.getCount() - 1)
        {
            //Reset current record
            VACR.view.Globals.currentRecord = 0;    
        }
        else
        {
            //Increase current record
            ++VACR.view.Globals.currentRecord;
        }

        VACR.view.Globals.doUpdate(this);

    },

    onButtonClick: function(button, e, eOpts) {
        // check the selected quiz data
        var quizData = Ext.data.StoreManager.lookup('quizDataStore');
        var quizResults = Ext.data.StoreManager.lookup('quizResultsStore');

        quizData.each(function(item, index, count) { 
            // Compare selected value with correct value    
            if(item.data.id !== item.selectedchoice){ // incorrect
                quizResults.add(item);

                var correctDesc = '';
                var selectedChoice = '';
                // Get the correct answer
                item.data.choices.each(function(choice, indx, cnt) {
                    if(choice.data.ID === item.data.id)
                    {
                        correctDesc = choice.data.MODELNO + " - " + choice.data.NAME;
                    }
                    else if(item.selectedchoice === choice.data.ID) {
                        selectedChoice = choice.data.MODELNO + " - " + choice.data.NAME;
                    }
                });
                quizResults.add({aircraft: correctDesc, selectedchoice: selectedChoice, pictures: choice.pictures});

            }
        });
        var missed = quizResults.count();
        var percent = Ext.Number.toFixed(((quizData.count() - missed)/quizData.count()) * 100);

        //alert('you missed ' + missed + '\nFor a ' + percent + '%');



        var dataView = Ext.create('Ext.view.View', {
            store: quizResults,
            tpl: [
            '<tpl for=".">',
            '<div class="thumb-wrap" id="{id}">',
            '<div class="thumb">{selectedchoice}"</div>',
            '<span class="x-editable">{id}</span>',
            '</div>',
            '</tpl>',
            '<div class="x-clear"></div>'
            ],
            multiSelect: false,
            height: 310,
            trackOver: true,
            overItemCls: 'x-item-over',
            itemSelector: 'div.thumb-wrap',
            emptyText: 'Nothing to display'
        });

        Ext.create('Ext.window.Window', {
            title: 'Quiz Results',
            height: 200,
            width: 400,
            layout: 'fit',
            items: [
            dataView
            ]
        }).show();
    },

    onPracticePanelExpand: function(p, eOpts) {
        // Build data collection
        var theData = Ext.data.StoreManager.lookup('listVacrStore');
        var quizData = Ext.data.StoreManager.lookup('quizDataStore');
        if(quizData.count() === 0){
            theData.each(function(item, index, count) { 
                var recID = item.data.ID;
                var recDesc = item.data.MODELNO + " - " + item.data.NAME;
                var phonyData = [];
                // for(var i=0; i<3; i++){
                var done = false;
                while (done === false){

                    var row = VACR.view.Globals.getRandomRow(recID, theData);
                    if(row.ID != recID)
                    {
                        // Check if already in array
                        var unique = true;
                        for(var x = 0; x < phonyData.length; x++){
                            if(phonyData[x].ID == row.ID)
                            {
                                unique = false;
                                continue;
                            }
                        }
                        if(unique)
                        phonyData.push(row);
                    }
                    if(phonyData.length == 3)
                    done = true;
                }

                quizData.add({id: recID, selectedchoice: -1, choices: 
                    [{choice:recID, description: recDesc},
                    {choice: phonyData[0].ID, description: phonyData[0].MODELNO + " - " + phonyData[0].NAME},
                    {choice:phonyData[1].ID, description: phonyData[1].MODELNO + " - " + phonyData[1].NAME},
                    {choice:phonyData[2].ID, description: phonyData[2].MODELNO + " - " + phonyData[2].NAME}],
                    pictures: item.data.PICTURES
                });
            });
        }
        VACR.view.Globals.currentRecord = 0;
        var record = quizData.getAt(VACR.view.Globals.currentRecord);
        var pictureQuizView = this.down('#pictureQuizView');
        // get the pictures field out of this record
        var picData = record.get('pictures');
        pictureQuizView.store.loadData(picData);

        // Load the choiceStore with data
        var choiceStore = Ext.data.StoreManager.lookup('choiceStore');
        var choiceData = record.get('choices');
        choiceData.sort(function(a,b){return b.choice-a.choice});
        choiceStore.loadData(choiceData);

        // If previously selected a value, set that value in the cbbox
        var cmbChoice = this.down('#cmbChoice');
        if(record.selectedchoice > 0)
        {
            cmbChoice.setValue(record.selectedchoice);
        }

    },

    onPanelAfterRender: function(component, eOpts) {


    },

    onContainerAfterLayout: function(container, layout, eOpts) {
        // check if logged in.
        App.checkUserLoggedIn();
    }

});