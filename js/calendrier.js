document.addEventListener('DOMContentLoaded', function() {
	var Draggable = FullCalendar.Draggable;
	var containerEl = document.getElementById('external-events');
	var calendarEl = document.getElementById('calendar');
  
	// Initialise les événements externes glissables
	new Draggable(containerEl, {
	  itemSelector: '.fc-event',
	  eventData: function(eventEl) {
		return {
		  title: eventEl.innerText,
		  id: eventEl.getAttribute('data-id') // Utilisez un attribut data-id pour stocker l'ID unique de l'événement
		};
	  }
	});
  
	// Initialise le calendrier FullCalendar
	var calendar = new FullCalendar.Calendar(calendarEl, {
	  timeZone: 'local',
	  locale: 'fr',
	  firstDay: 1,
	  headerToolbar: {
		left: 'prev,next today',
		center: 'title',
		right: 'dayGridMonth,timeGridWeek,timeGridDay'
	  },
	  editable: true,
	  dayMaxEvents: true,
	  events: 'http://163.5.143.216/reservation_api.php',
	  droppable: true,
	  eventClick: function(info) {
		if (confirm("Voulez-vous supprimer cette machine ?")) {
		  info.event.remove(); // Supprime l'événement du calendrier
		  // Appel AJAX pour supprimer l'événement du serveur
		  deleteEventOnServer(info.event.id);
		}
	  },
	  eventDrop: function(info) {
		var eventId = info.event.id;
		var newStart = info.event.start;
		var newEnd = info.event.end;
  
		// Mettre à jour l'événement sur le serveur
		console.log('hello world avec l’info:', info);
		updateEventOnServer(eventId, newStart, newEnd);
	  },
	  eventResize: function(info) {
		var eventId = info.event.id;
		var newStart = info.event.start;
		var newEnd = info.event.end;
  
		// Mettre à jour l'événement sur le serveur
		updateEventOnServer(eventId, newStart, newEnd);
	  }
	});
  
	calendar.render();
  });
  
  function deleteEventOnServer(eventId) {
	// Ici, mettre à jour votre serveur pour supprimer l'événement
	console.log('Suppression de l’événement avec l’id:', eventId);
	// Code pour supprimer l'événement sur le serveur 
	var eventData = {
		id: eventId,
		type: "delete",
	  };
	
	  // Requête AJAX pour supprimer l'événement sur le serveur
	  $.ajax({
		url: 'http://163.5.143.216/reservation_api.php',
		type: 'DELETE',
		contentType: 'application/json',
		data: JSON.stringify(eventData),
		success: function(response) {
		  console.log('Événement supprimé avec succès sur le serveur:', response);
		},
		error: function(xhr, status, error) {
		  console.error('Erreur lors de la suppression de l\'événement sur le serveur:', error);
		}
	  });
	};
  
  function updateEventOnServer(eventId, newStart, newEnd) {
	// Préparer les données à envoyer au serveur
	var eventData = {
	  id: eventId,
	  start: newStart.toISOString(),
	  end: newEnd ? newEnd.toISOString() : null,
	  hello_world: "Coucou"
	};
  
	// Faire une requête AJAX pour mettre à jour l'événement sur le serveur
	// Ici, vous devez utiliser votre propre logique pour envoyer les données au serveur
	// Par exemple, avec jQuery :
	// RTFM
	$.ajax({
	  url: 'http://163.5.143.216/calendrier.php',
	  type: 'POST',
	  contentType: 'application/json',
	  data: JSON.stringify(eventData),
	  success: function(response) {
		console.log('Événement mis à jour avec succès sur le serveur:', response);
	  },
	  error: function(xhr, status, error) {
		console.error('Erreur lors de la mise à jour de l\'événement sur le serveur:', error);
	  }
	});
  }
  