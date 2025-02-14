document.addEventListener("DOMContentLoaded", function() {
    const calendarEl = document.getElementById("calendar");

    fetch("events.php")
        .then(response => response.json())
        .then(events => {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: "dayGridMonth",
                initialDate: new Date(),
                selectable: true,
                events: events,
                dateClick: function(info) {
                    showAgenda(info.dateStr, events);
                }
            });
            calendar.render();
        });

    function showAgenda(date, events) {
        const modal = document.getElementById("agenda-modal");
        const agendaDetails = document.getElementById("agenda-details");

        const agendaForDate = events.filter(event => event.start === date);
        
        if (agendaForDate.length > 0) {
            agendaDetails.innerHTML = agendaForDate.map(event => 
                `<p><strong>${event.title}</strong>: ${event.description}</p>`
            ).join("");
        } else {
            agendaDetails.innerHTML = "<p>Tidak ada agenda pada tanggal ini.</p>";
        }

        modal.style.display = "block";
    }

    document.querySelector(".close").addEventListener("click", function() {
        document.getElementById("agenda-modal").style.display = "none";
    });

    window.onclick = function(event) {
        const modal = document.getElementById("agenda-modal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
});