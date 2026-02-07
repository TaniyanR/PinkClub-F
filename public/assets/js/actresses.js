const grid = document.querySelector('[data-grid="actresses"]');
if (grid) {
  const actresses = Array.from({ length: 24 }, (_, index) => ({
    name: `女優 ${index + 1}`,
    imageUrl: index % 4 === 0 ? null : `https://picsum.photos/seed/actress-${index}/320/320`,
  }));

  grid.innerHTML = '';
  actresses.forEach((actress) => {
    const card = document.createElement('article');
    card.className = 'actress-card';

    const media = document.createElement('div');
    media.className = 'actress-card__media';
    if (actress.imageUrl) {
      const img = document.createElement('img');
      img.src = actress.imageUrl;
      img.alt = actress.name;
      media.appendChild(img);
    }

    const name = document.createElement('div');
    name.className = 'actress-card__name';
    name.textContent = actress.name;

    card.appendChild(media);
    card.appendChild(name);
    grid.appendChild(card);
  });
}
