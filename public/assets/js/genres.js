const grid = document.querySelector('[data-genres-grid]');
const countEl = document.querySelector('[data-genre-count]');
const limitSelect = document.querySelector('[data-genre-limit]');
const searchInput = document.querySelector('[data-genre-search]');
const sortSelect = document.querySelector('[data-genre-sort]');

const allGenres = Array.from({ length: 48 }, (_, index) => {
    const id = index + 1;
    return {
        id,
        name: `ジャンル名 ${id}`,
        image: id % 5 === 0 ? '' : `https://picsum.photos/seed/genre-${id}/640/480`,
        popularRank: 48 - id,
        createdAt: 48 - index,
    };
});

const normalize = (value) => value.trim().toLowerCase();

const getFilteredGenres = () => {
    const keyword = normalize(searchInput?.value ?? '');
    let list = allGenres.slice();

    if (keyword) {
        list = list.filter((genre) => normalize(genre.name).includes(keyword));
    }

    const sortValue = sortSelect?.value ?? 'popular';
    if (sortValue === 'new') {
        list.sort((a, b) => b.createdAt - a.createdAt);
    } else {
        list.sort((a, b) => b.popularRank - a.popularRank);
    }

    return list;
};

const renderGenres = () => {
    if (!grid || !countEl) {
        return;
    }

    grid.innerHTML = '';
    const limit = Number(limitSelect?.value ?? 24);
    const filtered = getFilteredGenres();
    const visible = filtered.slice(0, limit);

    countEl.textContent = `${visible.length}件`;

    visible.forEach((genre) => {
        const card = document.createElement('article');
        card.className = 'genre-card';

        const media = document.createElement('a');
        media.className = 'genre-media';
        media.href = '#';
        media.setAttribute('aria-label', genre.name);

        const titleBadge = document.createElement('span');
        titleBadge.className = 'genre-media-title';
        titleBadge.textContent = genre.name;
        media.appendChild(titleBadge);

        if (genre.image) {
            const img = document.createElement('img');
            img.src = genre.image;
            img.alt = genre.name;
            img.addEventListener('error', () => {
                img.remove();
                media.classList.add('is-empty');
            });
            media.appendChild(img);
        } else {
            media.classList.add('is-empty');
        }

        const body = document.createElement('div');
        body.className = 'genre-body';
        body.innerHTML = `
            <a class="genre-name" href="#">${genre.name}</a>
            <a class="genre-btn" href="#">そのページへ</a>
        `;

        card.appendChild(media);
        card.appendChild(body);
        grid.appendChild(card);
    });
};

if (grid && countEl) {
    renderGenres();
}

limitSelect?.addEventListener('change', renderGenres);
sortSelect?.addEventListener('change', renderGenres);
searchInput?.addEventListener('input', renderGenres);

document.querySelectorAll('.pagination .page-btn').forEach((link) => {
    link.addEventListener('click', (event) => {
        event.preventDefault();
        window.alert('ページネーションはダミーです。');
    });
});
