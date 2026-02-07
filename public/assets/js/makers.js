const grid = document.querySelector('[data-grid="makers"]');
if (grid) {
  const items = Array.from({ length: 24 }, (_, index) => ({
    name: `メーカー ${index + 1}`,
    imageUrl: index % 4 === 0 ? null : `https://picsum.photos/seed/maker-${index}/400/240`,
  }));

  grid.innerHTML = '';
  items.forEach((item) => {
    const card = document.createElement('article');
    card.className = 'taxonomy-card';

    const media = document.createElement('div');
    media.className = 'taxonomy-card__media';
    if (item.imageUrl) {
      const img = document.createElement('img');
      img.src = item.imageUrl;
      img.alt = item.name;
      media.appendChild(img);
    } else {
      media.textContent = 'No Image';
    }

    const name = document.createElement('div');
    name.className = 'taxonomy-card__name';
    name.textContent = item.name;

    const button = document.createElement('a');
    button.className = 'button';
    button.textContent = 'そのページへ';
    button.href = '#';

    card.appendChild(media);
    card.appendChild(name);
    card.appendChild(button);
    grid.appendChild(card);
  });
}
