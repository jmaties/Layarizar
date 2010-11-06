/*
 * PorPOISe
 * Copyright 2009 SURFnet BV
 * Released under a permissive license (see LICENSE)
 */

var GUI = {
	addPOIAction: function (source) {
		var maxIndex = 0;

		var poiActionTables = document.body.select("form");
		for (var i = 0; i <= poiActionTables.length; i++) {
			var inputs = poiActionTables[i].select("input");
			if (inputs.length == 0) {
				/* weird, page must be corrupt */
				return;
			}
			var inputName = inputs[0].name;
			var indexWithBrackets = inputName.match(/\[.+\]/);
			if (indexWithBrackets.length == 0) {
				/* again, invalid */
				return;
			}
			var index = parseInt(indexWithBrackets[0].substr(1, indexWithBrackets[0].length - 2));
			if (index > maxIndex) {
				maxIndex = index;
			}
		}

		var newIndex = maxIndex + 1;

		var newRow = document.createElement("tr");
		var td = document.createElement("td");
		td.insert("Action<br><button type=\"button\" onclick=\"GUI.removePOIAction(" + newIndex + ")\">Remove</button>");
		newRow.appendChild(td);
		td = document.createElement("td");
		newRow.appendChild(td);
		var actionTable = document.createElement("table");
		td.appendChild(actionTable);
		actionTable.addClassName("action");
		for (var i = 0; i < 4; i++) {
			var tr = document.createElement("tr");
			var labelTd = document.createElement("td");
			var valueTd = document.createElement("td");
			if (i == 0) {
				labelTd.textContent = "Label";
				var input = document.createElement("input");
				input.type = "text";
				input.name = "actions[" + newIndex + "][label]";
				valueTd.appendChild(input);
			} else if (i == 1) {
				labelTd.textContent = "URI";
				var input = document.createElement("input");
				input.type = "text";
				input.name = "actions[" + newIndex + "][uri]";
				valueTd.appendChild(input);
			} else if (i == 2) {
				labelTd.textContent = "Auto-trigger range";
				var input = document.createElement("input");
				input.type = "text";
				input.name = "actions[" + newIndex + "][autoTriggerRange]";
				input.size = 2;
				valueTd.appendChild(input);
			} else if (i == 3) {
				labelTd.textContent = "Auto-trigger only";
				var select = document.createElement("select");
				select.name = "actions[" + newIndex + "][autoTriggerOnly]";
				var option = document.createElement("option");
				option.textContent = "Yes";
				option.value = 1;
				select.appendChild(option);
				option = document.createElement("option");
				option.textContent = "No";
				option.value = 0;
				option.selected = "selected";
				select.appendChild(option);
				valueTd.appendChild(select);
			} else {
				/* 'scuse me? */
				continue;
			}
			tr.appendChild(labelTd);
			tr.appendChild(valueTd);
			actionTable.appendChild(tr);
		}
		var sourceRow = source.up("fieldset");
		sourceRow.insert({ before: newRow });
	}

	, removePOIAction: function(indexToRemove) {
		var poiActionTables = document.body.select("table.action");
		for (var i = 0; i < poiActionTables.length; i++) {
			var inputs = poiActionTables[i].select("input");
			if (inputs.length == 0) {
				/* weird, page must be corrupt */
				return;
			}
			var inputName = inputs[0].name;
			var indexWithBrackets = inputName.match(/\[.+\]/);
			if (indexWithBrackets.length == 0) {
				/* again, invalid */
				return;
			}
			var index = parseInt(indexWithBrackets[0].substr(1, indexWithBrackets[0].length - 2));
			if (index == indexToRemove) {
				poiActionTables[i].up("tr").remove();
				return;
			}
		}
	}		
}
