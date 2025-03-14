document.addEventListener("DOMContentLoaded", function () {
    const upcomingSchedulesList = document.getElementById('upcomingSchedulesList');
    const appointmentsList = document.getElementById('appointmentsList');
    const equipmentRequestsList = document.getElementById('equipmentRequestsList');
    const calendarEl = document.getElementById('calendar');
    const sidebar = document.getElementById("sidebar");
    const menuToggle = document.getElementById("toggleSidebar");

    if (!sidebar || !menuToggle || !calendarEl) {
        console.error("One or more required elements are missing in the DOM.");
        return;
    }

    function handleSidebar() {
        sidebar.classList.toggle("collapsed", window.innerWidth < 1900);
        menuToggle.style.display = window.innerWidth < 1900 ? "block" : "none";
    }
    handleSidebar();
    window.addEventListener("resize", handleSidebar);

    menuToggle.addEventListener("click", function (event) {
        event.stopPropagation();
        sidebar.classList.toggle("collapsed");
        sidebar.classList.toggle("show");
    });

    document.addEventListener("click", function (event) {
        if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove("show");
        }
    });

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'timeGridDay' : 'dayGridMonth',
        headerToolbar: {
            left: 'prev next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        selectable: true,
        editable: true,
        events: [],
        eventClick: function (info) {
            openEventModal(info.event);
        },
        eventRemove: function (info) {
            removeListItemByEvent(info.event);
        }
    });
    calendar.render();

    function addListItem(list, text, eventId, eventDate) {
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'small');
        li.textContent = text;
        li.dataset.eventId = eventId;
        li.dataset.eventDate = eventDate;

        list.appendChild(li);
        sortListByDate(list);
    }

    function sortListByDate(list) {
        const items = Array.from(list.children);
        items.sort((a, b) => new Date(a.dataset.eventDate) - new Date(b.dataset.eventDate));
        items.forEach(item => list.appendChild(item));
    }

    function removeListItem(list, eventId) {
        const itemToRemove = list.querySelector(`li[data-event-id="${eventId}"]`);
        if (itemToRemove) {
            itemToRemove.remove();
        }
    }

    function removeListItemByEvent(event) {
        const category = event.extendedProps.category;
        const eventId = event.id;
        if (!eventId) return;

        const listMap = {
            public: upcomingSchedulesList,
            personal: appointmentsList,
            equipment: equipmentRequestsList
        };

        const targetList = listMap[category];
        if (targetList) {
            removeListItem(targetList, eventId);
        }
    }

    function openEventModal(event) {
        const category = event.extendedProps.category;
        switch (category) {
            case 'public':
                populatePublicEventModal(event);
                break;
            case 'personal':
                populatePersonalEventModal(event);
                break;
            case 'equipment':
                openRequestDetailsModal(event);
                break;
        }
    }

    function deleteEvent(event, modal) {
        event.remove();
        removeListItemByEvent(event);
        modal.hide();
    }

    document.getElementById("publicAppointmentForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const title = document.getElementById("publicTitle").value;
        const date = document.getElementById("publicDate").value;
        const category = document.getElementById("publicCategory").value;
        const colorMap = { general: 'green', college: 'red', shs: 'blue' };
        const color = colorMap[category] || 'gray';
        
        const newEvent = calendar.addEvent({
            id: `event-${Date.now()}`,
            title,
            start: date,
            extendedProps: { category: 'public', subCategory: category },
            color: color
        });

        addListItem(upcomingSchedulesList, `${title} - ${date}`, newEvent.id, date);
        bootstrap.Modal.getInstance(document.getElementById('setPublicAppointmentModal')).hide();
        this.reset();
    });

    document.getElementById("personalAppointmentForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const name = document.getElementById("personalName").value;
        const date = document.getElementById("personalDate").value;
        const time = document.getElementById("personalTime").value;
        const formattedDateTime = `${date}T${time}`;
        
        const newEvent = calendar.addEvent({
            id: `event-${Date.now()}`,
            start: formattedDateTime,
            extendedProps: { name, category: 'personal' },
            color: 'black'
        });

        addListItem(appointmentsList, `${name} - ${date} at ${time}`, newEvent.id, date);
        bootstrap.Modal.getInstance(document.getElementById('setPersonalAppointmentModal')).hide();
        this.reset();
    });

    document.getElementById("equipmentRequestForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const name = document.getElementById("requestorName").value;
        const date = document.getElementById("requestDate").value;
        const item = document.getElementById("requestedItem").value;
        
        const newEvent = calendar.addEvent({
            id: `event-${Date.now()}`,
            title: `Equipment Request: ${item}`,
            start: date,
            extendedProps: { name, category: 'equipment' },
            color: 'purple'
        });

        addListItem(equipmentRequestsList, `${item} requested by ${name} on ${date}`, newEvent.id, date);
        bootstrap.Modal.getInstance(document.getElementById('requestEquipmentModal')).hide();
        this.reset();
    });
});
