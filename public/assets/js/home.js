const createMedia = (imageUrl, alt) => {
  const media = document.createElement('div');
  media.className = 'product-card__media';
  if (imageUrl) {
    const img = document.createElement('img');
    img.src = imageUrl;
    img.alt = alt;
    media.appendChild(img);
  } else {
    media.textContent = 'No Image';
  }
  return media;
};

const createProductCard = (item) => {
  const card = document.createElement('article');
  card.className = 'product-card';

  card.appendChild(createMedia(item.imageUrl, item.title));

  const body = document.createElement('div');
  body.className = 'product-card__body';

  const title = document.createElement('div');
  title.className = 'product-card__title';
  title.textContent = item.title;

  const actions = document.createElement('div');
  actions.className = 'product-card__actions';

  const buttons = [
    { label: 'サンプル動画', className: 'button' },
    { label: 'サンプル画像', className: 'button' },
    { label: 'FANZAで購入', className: 'button button--primary', href: '#' },
  ];

  buttons.forEach((button) => {
    const btn = document.createElement('a');
    btn.className = button.className;
    btn.textContent = button.label;
    btn.href = button.href || '#';
    btn.target = button.href ? '_blank' : '';
    actions.appendChild(btn);
  });

  body.appendChild(title);
  body.appendChild(actions);
  card.appendChild(body);
  return card;
};

const renderProductGrid = (selector, items) => {
  const grid = document.querySelector(selector);
  if (!grid) return;
  grid.innerHTML = '';
  items.forEach((item) => grid.appendChild(createProductCard(item)));
};

const createActressCard = (actress) => {
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
  return card;
};

const renderActressGrid = (selector, actresses) => {
  const grid = document.querySelector(selector);
  if (!grid) return;
  grid.innerHTML = '';
  actresses.forEach((actress) => grid.appendChild(createActressCard(actress)));
};

const createTileCard = (item) => {
  const card = document.createElement('article');
  card.className = 'tile-card';

  const media = document.createElement('div');
  media.className = 'tile-card__media';
  if (item.imageUrl) {
    const img = document.createElement('img');
    img.src = item.imageUrl;
    img.alt = item.name;
    media.appendChild(img);
  } else {
    media.textContent = 'No Image';
  }

  const name = document.createElement('div');
  name.className = 'tile-card__name';
  name.textContent = item.name;

  const button = document.createElement('a');
  button.className = 'button';
  button.textContent = 'そのページへ';
  button.href = '#';

  card.appendChild(media);
  card.appendChild(name);
  card.appendChild(button);
  return card;
};

const renderTileRows = (selector, items) => {
  const container = document.querySelector(selector);
  if (!container) return;
  container.innerHTML = '';

  const rowSize = 6;
  const rows = Math.ceil(items.length / rowSize);
  for (let i = 0; i < rows; i += 1) {
    const row = document.createElement('div');
    row.className = 'tile-row';
    items.slice(i * rowSize, (i + 1) * rowSize).forEach((item) => {
      row.appendChild(createTileCard(item));
    });
    container.appendChild(row);
  }
};

const createProducts = (count, offset = 0) =>
  Array.from({ length: count }, (_, index) => ({
    title: `サンプル作品タイトル ${offset + index + 1}`,
    imageUrl: (index + offset) % 4 === 0 ? null : `https://picsum.photos/seed/product-${offset + index}/360/480`,
  }));

const createTiles = (label, count) =>
  Array.from({ length: count }, (_, index) => ({
    name: `${label} ${index + 1}`,
    imageUrl: index % 4 === 0 ? null : `https://picsum.photos/seed/${label}-${index}/400/225`,
  }));

const newTop = createProducts(4, 0);
const newBottom = createProducts(6, 4);
const pickupTop = createProducts(4, 10);
const pickupBottom = createProducts(6, 14);

renderProductGrid('[data-grid="new-top"]', newTop);
renderProductGrid('[data-grid="new-bottom"]', newBottom);
renderProductGrid('[data-grid="pickup-top"]', pickupTop);
renderProductGrid('[data-grid="pickup-bottom"]', pickupBottom);

renderActressGrid('[data-grid="actress"]', [
  { name: '天音 まひな', imageUrl: 'https://picsum.photos/seed/actress-1/300/300' },
  { name: '葵 さくら', imageUrl: null },
  { name: '渚 みつき', imageUrl: 'https://picsum.photos/seed/actress-3/300/300' },
  { name: '石原 希', imageUrl: 'https://picsum.photos/seed/actress-4/300/300' },
  { name: '宮下 玲奈', imageUrl: null },
]);

renderTileRows('[data-rows="series"]', createTiles('シリーズ', 18));
renderTileRows('[data-rows="maker"]', createTiles('メーカー', 18));
renderTileRows('[data-rows="label"]', createTiles('レーベル', 18));
