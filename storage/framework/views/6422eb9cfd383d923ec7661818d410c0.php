<?php $__env->startSection('content'); ?>
    <section class="panel">
        <div class="panel__header">
            <h2 id="form-title">Nuevo elemento del menú</h2>
            <button type="button" id="btn-reset" class="btn btn--ghost" hidden>Cancelar edición</button>
        </div>

        <form id="menu-form" class="form-grid">
            <input type="hidden" id="item-id" value="">

            <label>
                Nombre
                <input type="text" id="name" required maxlength="150" placeholder="Ej. Risotto de Hongos">
            </label>

            <label>
                Precio (USD)
                <input type="number" id="price" required min="0" step="0.01" placeholder="0.00">
            </label>

            <label>
                Categoría
                <select id="category" required>
                    <option value="">Selecciona...</option>
                    <option value="entrada">Entrada</option>
                    <option value="plato_fuerte">Plato Fuerte</option>
                    <option value="postre">Postre</option>
                    <option value="bebida">Bebida</option>
                    <option value="acompanamiento">Acompañamiento</option>
                </select>
            </label>

            <label>
                URL de imagen
                <input type="url" id="image_url" placeholder="https://...">
            </label>

            <label class="form-grid__full">
                Descripción
                <textarea id="description" rows="2" maxlength="1000" placeholder="Breve descripción del platillo"></textarea>
            </label>

            <label class="form-grid__checkbox">
                <input type="checkbox" id="available" checked>
                Disponible
            </label>

            <div class="form-grid__full form-actions">
                <button type="submit" id="btn-submit" class="btn btn--primary">Guardar elemento</button>
                <span id="form-message" class="form-message"></span>
            </div>
        </form>
    </section>

    <section class="panel">
        <div class="panel__header">
            <h2>Menú actual</h2>
            <div class="filters">
                <select id="filter-category">
                    <option value="">Todas las categorías</option>
                    <option value="entrada">Entrada</option>
                    <option value="plato_fuerte">Plato Fuerte</option>
                    <option value="postre">Postre</option>
                    <option value="bebida">Bebida</option>
                    <option value="acompanamiento">Acompañamiento</option>
                </select>
                <input type="search" id="filter-search" placeholder="Buscar por nombre...">
            </div>
        </div>

        <div id="menu-list" class="menu-grid">
            <p class="empty-state">Cargando menú...</p>
        </div>
    </section>

    

<script>
const API_BASE = "<?php echo e(url('/api/menu-items')); ?>";

const els = {
    form: document.getElementById('menu-form'),
    id: document.getElementById('item-id'),
    name: document.getElementById('name'),
    price: document.getElementById('price'),
    category: document.getElementById('category'),
    imageUrl: document.getElementById('image_url'),
    description: document.getElementById('description'),
    available: document.getElementById('available'),
    formTitle: document.getElementById('form-title'),
    formMessage: document.getElementById('form-message'),
    btnSubmit: document.getElementById('btn-submit'),
    btnReset: document.getElementById('btn-reset'),
    list: document.getElementById('menu-list'),
    filterCategory: document.getElementById('filter-category'),
    filterSearch: document.getElementById('filter-search'),
};

const CATEGORY_LABELS = {
    entrada: 'Entrada',
    plato_fuerte: 'Plato Fuerte',
    postre: 'Postre',
    bebida: 'Bebida',
    acompanamiento: 'Acompañamiento',
};

let searchTimeout = null;

async function fetchMenu() {
    const params = new URLSearchParams();
    if (els.filterCategory.value) params.set('category', els.filterCategory.value);
    if (els.filterSearch.value.trim()) params.set('search', els.filterSearch.value.trim());
    params.set('per_page', 50);

    els.list.innerHTML = '<p class="empty-state">Cargando menú...</p>';

    try {
        const res = await fetch(`${API_BASE}?${params.toString()}`, {
            headers: { 'Accept': 'application/json' },
        });
        const json = await res.json();
        renderMenu(json.data ?? []);
    } catch (err) {
        els.list.innerHTML = '<p class="empty-state">Error al cargar el menú. ¿Está corriendo el servidor?</p>';
    }
}

function renderMenu(items) {
    if (!items.length) {
        els.list.innerHTML = '<p class="empty-state">No hay elementos que coincidan con el filtro.</p>';
        return;
    }

    els.list.innerHTML = items.map(item => `
        <article class="card ${item.available ? '' : 'card--unavailable'}">
            <div class="card__image" style="background-image:url('${item.image_url ?? ''}')"></div>
            <div class="card__body">
                <span class="badge">${CATEGORY_LABELS[item.category] ?? item.category}</span>
                <h3>${escapeHtml(item.name)}</h3>
                <p class="card__desc">${escapeHtml(item.description ?? '')}</p>
                <div class="card__footer">
                    <span class="price">$${Number(item.price).toFixed(2)}</span>
                    <span class="status">${item.available ? 'Disponible' : 'No disponible'}</span>
                </div>
                <div class="card__actions">
                    <button class="btn btn--small" onclick='editItem(${JSON.stringify(item)})'>Editar</button>
                    <button class="btn btn--small btn--danger" onclick="deleteItem(${item.id}, '${escapeHtml(item.name).replace(/'/g, "&#39;")}')">Eliminar</button>
                </div>
            </div>
        </article>
    `).join('');
}

function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str ?? '';
    return div.innerHTML;
}

function editItem(item) {
    els.id.value = item.id;
    els.name.value = item.name;
    els.price.value = item.price;
    els.category.value = item.category;
    els.imageUrl.value = item.image_url ?? '';
    els.description.value = item.description ?? '';
    els.available.checked = item.available;
    els.formTitle.textContent = `Editando: ${item.name}`;
    els.btnSubmit.textContent = 'Actualizar elemento';
    els.btnReset.hidden = false;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function resetForm() {
    els.form.reset();
    els.id.value = '';
    els.available.checked = true;
    els.formTitle.textContent = 'Nuevo elemento del menú';
    els.btnSubmit.textContent = 'Guardar elemento';
    els.btnReset.hidden = true;
    els.formMessage.textContent = '';
}

els.btnReset.addEventListener('click', resetForm);

els.form.addEventListener('submit', async (e) => {
    e.preventDefault();
    els.formMessage.textContent = '';

    const payload = {
        name: els.name.value,
        price: parseFloat(els.price.value),
        category: els.category.value,
        image_url: els.imageUrl.value || null,
        description: els.description.value || null,
        available: els.available.checked,
    };

    const isEdit = Boolean(els.id.value);
    const url = isEdit ? `${API_BASE}/${els.id.value}` : API_BASE;
    const method = isEdit ? 'PUT' : 'POST';

    try {
        const res = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        });
        const json = await res.json();

        if (!res.ok) {
            const firstError = json.errors ? Object.values(json.errors)[0][0] : json.message;
            els.formMessage.textContent = firstError || 'Ocurrió un error.';
            els.formMessage.className = 'form-message form-message--error';
            return;
        }

        els.formMessage.textContent = json.message || 'Guardado correctamente.';
        els.formMessage.className = 'form-message form-message--success';
        resetForm();
        fetchMenu();
    } catch (err) {
        els.formMessage.textContent = 'Error de conexión con la API.';
        els.formMessage.className = 'form-message form-message--error';
    }
});

async function deleteItem(id, name) {
    if (!confirm(`¿Eliminar "${name}" del menú?`)) return;

    try {
        const res = await fetch(`${API_BASE}/${id}`, {
            method: 'DELETE',
            headers: { 'Accept': 'application/json' },
        });
        if (res.ok) fetchMenu();
    } catch (err) {
        alert('Error al eliminar el elemento.');
    }
}

els.filterCategory.addEventListener('change', fetchMenu);
els.filterSearch.addEventListener('input', () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(fetchMenu, 350);
});

fetchMenu();
</script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\kodigo\la-buena-mesa-api\resources\views/menu/index.blade.php ENDPATH**/ ?>