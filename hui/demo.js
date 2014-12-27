Ext.require('Ext.ux.Cover');

Ext.application({
	name: 'Cover',
	
	viewport: {
		autoMaximize: true
	},

	launch: function(){

		var cover = Ext.create('Ext.ux.Cover', {
			itemCls: 'my-cover-item',
			//These are just for demo purposes.
			height: (Ext.os.deviceType !== 'Phone')? 300: undefined,
			width: (Ext.os.deviceType !== 'Phone')? 800: undefined,
			//end-demo
		    itemTpl : [
				'<div>',
					'<div class="dev">{firstName} {lastName}</div>',
					'<div class="company">{company}</div>',
					'<div class="image"><tpl if="image"><img  src="{image}"></tpl></div>',
				'</div>'
			],
			store : {
			    fields: ['firstName', 'lastName', 'company', 'image'],
			    data: [
			        {firstName: 'Tommy',   lastName: 'Maintz', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Rob',     lastName: 'Dougan', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Max',     lastName: 'Fierro', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
     {firstName: 'Rob',     lastName: 'Dougan', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Max',     lastName: 'Fierro', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
     {firstName: 'Rob',     lastName: 'Dougan', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Max',     lastName: 'Fierro', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
     {firstName: 'Rob',     lastName: 'Dougan', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Max',     lastName: 'Fierro', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
     {firstName: 'Rob',     lastName: 'Dougan', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Max',     lastName: 'Fierro', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
     {firstName: 'Rob',     lastName: 'Dougan', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Max',     lastName: 'Fierro', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
     {firstName: 'Rob',     lastName: 'Dougan', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Max',     lastName: 'Fierro', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Ed',      lastName: 'Spencer', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Jamie',   lastName: 'Avins', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Aaron',   lastName: 'Conran', company: 'Sencha', image: './img.jpg'},
			        {firstName: 'Dave',    lastName: 'Kaneda', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Michael', lastName: 'Mullany', company: 'Sencha', image: './img.jpg'},
	   		        {firstName: 'Abraham', lastName: 'Elias', company: 'Sencha', image: './img.jpg'},
				    {firstName: 'Jay',     lastName: 'Robinson', company: 'Sencha', image: './img.jpg'}
			    ]
			},
			selectedIndex: 2,
			listeners:{
				itemdoubletap: function(cover, idx){
					var currenSong = document.createElement("audio");
                                        currenSong.setAttribute("src", "http://s3.amazonaws.com/audiojs/04-islands-is-the-limit.mp3");
                                        var seeking=false;
                                        currenSong.play();

				},
				itemtap: function(cover, idx){
					//alert(idx);
				},
				scope: this
			}
		});

				
		var tab = Ext.create('Ext.tab.Panel',{
			tabBarPosition: 'bottom',
			items:[{
				title: 'cover',
				iconCls: 'favorites',
				//Demo purpose
				layout: (Ext.os.deviceType === 'Phone')? 'fit': {
					type: 'vbox',
					pack:'center',
					align: 'center'
				},
				//end demo
				items: [cover]
			}]
		});
		
		//weird fix to call refresh when orientation changes
	//	Ext.Viewport.on('orientationchange', function(){cover.refresh();})
		Ext.Viewport.add(tab);
	}
});