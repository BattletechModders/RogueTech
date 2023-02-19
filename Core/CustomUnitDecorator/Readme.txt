defines CustomComponent 
DecoratorComponent which makes certain component icon be visible above unit icon, left side, up to three icons
		"DecoratorComponent":{
			"Text":"S",               - text above component icon (only first two characters used)
			"Color":"#FF0000FF",      - color for an icon, #RGBA, if omitted default component color used
			"Icon":"C3Systems",       - icon to be displayed, if omitted component icon from description is used
			"Importance": 0           - components with higher Importance goes first (upper)
		}
Each component can have up to three icons in row:
		"DecoratorComponent":[
			{
				"Text":"S",               
				"Color":"#FF0000FF",      
				"Icon":"C3Systems",       
				"Importance": 0           
			},
			{
				"Text":"T",               
				"Color":"#FFFF00FF",      
				"Icon":"C3Systems",       
				"Importance": 0           
			}
		]