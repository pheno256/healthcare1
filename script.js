let map;

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 1.3733, lng: 32.2903 }, 
        zoom: 7,
    });

    fetchDoctors(); 
}

async function fetchDoctors(searchLocation = null) {
    try {
        const response = await fetch('backend/fetch_doctors.php');
        const doctors = await response.json();

        for (const doctor of doctors) {
            const locationInput = searchLocation || doctor.location;

            const geocodeResponse = await fetch(
                `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(locationInput)}&key=YOUR_GOOGLE_MAPS_API_KEY`
            );
            const geocodeData = await geocodeResponse.json();

            if (geocodeData.status === 'OK') {
                const location = geocodeData.results[0].geometry.location;

                new google.maps.Marker({
                    position: location,
                    map: map,
                    title: doctor.name
                });

                if (searchLocation) {
                    map.setCenter(location);
                    map.setZoom(12);
                }
            } else {
                console.warn('Location not found for', doctor.name);
            }
        }
    } catch (error) {
        console.error('Error fetching doctors:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('searchForm');
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const userLocation = document.getElementById('location').value;
            if (userLocation.trim() !== "") {
                fetchDoctors(userLocation);
            }
        });
    }
});
