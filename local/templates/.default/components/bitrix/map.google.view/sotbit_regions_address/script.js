

if (!window.BX_GMapAddPlacemark)
{
	window.BX_GMapAddPlacemark = function(arPlacemark, map_id)
	{
		var map = GLOBAL_arMapObjects[map_id];
		
		if (null == map)
			return false;

		if(!arPlacemark.LAT || !arPlacemark.LON)
			return false;

		var params = {
			'position': new google.maps.LatLng(arPlacemark.LAT, arPlacemark.LON),
			'map': map
		};
		if(null != arPlacemark.MARKER && arPlacemark.MARKER.length > 0) {
			params.icon = {
				 url: arPlacemark.MARKER,
				 scaledSize: new google.maps.Size(64, 64)
			};
		}
		else {
			const rootStyles = getComputedStyle(document.querySelector(':root'));
			const mainColor = rootStyles.getPropertyValue('--main-color').replace('#', '').trim();
			
			params.icon = {
    			url: 'data:image/svg+xml;utf-8, \ '+
				'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="30" viewBox="0 0 24 30" fill="%23'+mainColor+'">'+
				'<path d="M24 10.9589C23.7414 19.5797 15.0106 27.4878 12.6071 29.5052C12.2519 29.8034 11.7522 29.7974 '+
				'11.4025 29.4928C8.97761 27.3804 0 19.016 0 10.9589C0 4.90647 5.37258 0 12 0C18.6274 0 24 4.90647 24 10.9589Z"/>'+
				'<path d="M16.9412 11.5908C16.9412 14.2267 14.729 16.3636 12 16.3636C9.27108 16.3636 7.05884 14.2267 7.05884 11.5908C7.05884 8.95494 '+
				 '9.27108 6.81812 12 6.81812C14.729 6.81812 16.9412 8.95494 16.9412 11.5908Z" fill="white"/>'+
				'</svg>'
		   };
		}
		
		var obPlacemark = new google.maps.Marker(params);
		
		if (BX.type.isNotEmptyString(arPlacemark.TEXT))
		{
            let contentLayout = `<div class="infobox-inner">` + arPlacemark.TEXT + `</div><div class="map_popover__arrow"></div>`;
			
			obPlacemark.infowin = new InfoBox({
				content: contentLayout,
				alignBottom:true,
				disableAutoPan: false,
				pixelOffset: new google.maps.Size(-120, 0),
				zIndex: null,
				boxStyle: {
					backgroundColor:"#fff",
					width: "240px",
				}
		   });

			google.maps.event.addListener(obPlacemark, 'click', function() {
				if (null != window['__bx_google_infowin_opened_' + map_id])
					window['__bx_google_infowin_opened_' + map_id].close();
				this.infowin.open(this.map, this);
				window['__bx_google_infowin_opened_' + map_id] = this.infowin;
			});
		}
		
		return obPlacemark;
	}
}

if (null == window.BXWaitForMap_view)
{
	function BXWaitForMap_view(map_id)
	{
		if (null == window.GLOBAL_arMapObjects)
			return;
	
		if (window.GLOBAL_arMapObjects[map_id])
			window['BX_SetPlacemarks_' + map_id]();
		else
			setTimeout('BXWaitForMap_view(\'' + map_id + '\')', 300);
	}
}