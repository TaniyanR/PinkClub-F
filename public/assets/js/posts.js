const createProductCard = (item) => {
  const card = document.createElement('article');
  card.className = 'product-card';

  const media = document.createElement('div');
  media.className = 'product-card__media';
  if (item.imageUrl) {
    const img = document.createElement('img');
    img.src = item.imageUrl;
    img.alt = item.title;
    media.appendChild(img);
  } else {
    media.textContent = 'No Image';
  }

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
  card.appendChild(media);
  card.appendChild(body);
  return card;
};

const grid = document.querySelector('[data-grid="posts"]');
if (grid) {
  const items = Array.from({ length: 12 }, (_, index) => ({
    title: `記事一覧サンプル ${index + 1}`,
    imageUrl: index % 4 === 0 ? null : `https://picsum.photos/seed/post-${index}/360/480`,
  }));
  grid.innerHTML = '';
  items.forEach((item) => grid.appendChild(createProductCard(item)));
}
