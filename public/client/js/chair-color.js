document.addEventListener('DOMContentLoaded', function() {
    const chairs = document.querySelectorAll('.buying-scheme__chair');

    chairs.forEach(function(chair) {
        chair.addEventListener('click', function() {
            let currentChairType = chair.getAttribute('data-chair-type') || 'standart';
            let previousChairType = chair.getAttribute('data-previous-chair-type') || 'standart';

            if (currentChairType === 'standart') {
                chair.classList.remove('buying-scheme__chair_standart');
                chair.classList.add('buying-scheme__chair_selected');
                currentChairType = 'selected';
            } else if (currentChairType === 'vip') {
                chair.classList.remove('buying-scheme__chair_vip');
                chair.classList.add('buying-scheme__chair_selected');
                currentChairType = 'selected';
            } else if (currentChairType === 'selected') {
                chair.classList.remove('buying-scheme__chair_selected');
                chair.classList.add(`buying-scheme__chair_${previousChairType}`);
                currentChairType = previousChairType;
            }

            chair.setAttribute('data-chair-type', currentChairType);
            updateChairName(chair, currentChairType);
        });
    });

    function updateChairName(chair, chairType) {
        const i = chair.getAttribute('data-i');
        const j = chair.getAttribute('data-j');
        chair.setAttribute('name', `seats[${i}][${j}][${chairType}]`);
    }
});
