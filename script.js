$(function() {
	$('#modeSelector #table tr:odd').css('background-color','#EEE');
	$('#modeSelector #controls').change(function() {
		keyName = $(this).find('select[name=key] option:selected').text();
		relatives = $(this).find(':checkbox:checked').val();
		$.get('ajax.php', {key: keyName, relatives: relatives},
			function(data){
				data = $(data);
				$('#modeSelector #table tr').each(function(modeIndex, modeName) {
					$(this).find('.name').html(data.get(modeIndex).name);
					$(this).find('.key').html(data.get(modeIndex).key);
				});
		});
	});
});
