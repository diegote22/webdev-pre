@if(isset($course))
<div x-data="reqsManager()" x-init="init()" class="space-y-4">
    <div class="flex justify-end">
        <button @click="openCreate()" class="px-3 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700">Nuevo requisito</button>
    </div>
    <ul class="divide-y rounded border bg-white" @dragover.prevent @drop="onDrop">
        @foreach($course->requirements()->orderBy('position')->get() as $req)
            <li class="flex items-center gap-2 p-2 cursor-move hover:bg-gray-50" draggable="true" @dragstart="onDragStart($event, {{ $req->id }})" @dragover.prevent="onDragOver($event, $el)" data-id="{{ $req->id }}">
                <span class="text-gray-400">≡</span>
                <span class="flex-1">{{ $req->text }}</span>
                <div class="flex gap-2">
                    <button class="px-2 py-1 text-sm text-amber-700 bg-amber-100 rounded hover:bg-amber-200" @click="openEdit({ id: {{ $req->id }}, text: @js($req->text) })">Editar</button>
                    <button class="px-2 py-1 text-sm text-red-700 bg-red-100 rounded hover:bg-red-200" @click="openDelete({ id: {{ $req->id }}, text: @js($req->text) })">Eliminar</button>
                </div>
            </li>
        @endforeach
        @if($course->requirements()->count() === 0)
            <li class="p-3 text-sm text-gray-500">Aún no hay requisitos definidos.</li>
        @endif
    </ul>
    <div class="flex justify-end">
        <form x-ref="reorderForm" method="POST" action="{{ route('courses.requirements.reorder', $course) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="order" :value="JSON.stringify(order)">
            <button type="submit" class="px-3 py-2 bg-gray-100 rounded hover:bg-gray-200">Guardar orden</button>
        </form>
    </div>

    <!-- Modal base -->
    <div x-show="modal.open" x-cloak class="fixed inset-0 z-40 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/30" @click="closeModal()"></div>
        <div class="relative z-50 w-full max-w-lg bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold mb-4" x-text="modal.title"></h3>
            <template x-if="modal.type==='create' || modal.type==='edit'">
                <form :action="modal.action" method="POST" class="space-y-4">
                    @csrf
                    <template x-if="modal.type==='edit'"><input type="hidden" name="_method" value="PUT"></template>
                    <input name="text" class="w-full border rounded p-2" :value="modal.payload.text || ''" placeholder="Descripción del requisito" required>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeModal()" class="px-3 py-2 bg-gray-100 rounded">Cancelar</button>
                        <button class="px-3 py-2 bg-indigo-600 text-white rounded">Guardar</button>
                    </div>
                </form>
            </template>
            <template x-if="modal.type==='delete'">
                <form :action="modal.action" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <p>¿Eliminar el requisito: <span class="font-medium" x-text="modal.payload.text"></span>?</p>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeModal()" class="px-3 py-2 bg-gray-100 rounded">Cancelar</button>
                        <button class="px-3 py-2 bg-red-600 text-white rounded">Eliminar</button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>

<script>
function reqsManager() {
    return {
        order: [],
        draggingId: null,
        modal: { open: false, type: null, title: '', action: '', payload: {} },
        init() { this.refreshOrder(); },
        refreshOrder() { this.order = Array.from(document.querySelectorAll('[data-id]')).map(li => Number(li.dataset.id)); },
        onDragStart(e, id) { this.draggingId = id; this.draggingEl = e.target.closest('[data-id]'); e.dataTransfer.effectAllowed = 'move'; },
        onDragOver(e, el) {
            if (!this.draggingEl || el === this.draggingEl) return;
            const box = el.getBoundingClientRect();
            const halfway = box.top + box.height / 2;
            const parent = el.parentNode;
            if (e.clientY < halfway) parent.insertBefore(this.draggingEl, el);
            else parent.insertBefore(this.draggingEl, el.nextSibling);
        },
        onDrop(e) {
            const list = e.currentTarget;
            const items = Array.from(list.querySelectorAll('[data-id]'));
            items.sort((a,b)=> a.getBoundingClientRect().top - b.getBoundingClientRect().top);
            this.order = items.map(el => Number(el.dataset.id));
            this.$refs?.reorderForm?.scrollIntoView({behavior:'smooth', block:'nearest'});
        },
        openCreate() {
            this.modal = { open: true, type: 'create', title: 'Nuevo requisito', action: @js(route('courses.requirements.store', $course)), payload: {} };
        },
        openEdit(req) {
            this.modal = { open: true, type: 'edit', title: 'Editar requisito', action: @js(route('courses.requirements.update', [$course, 0])).replace('/0', '/' + req.id), payload: req };
        },
        openDelete(req) {
            this.modal = { open: true, type: 'delete', title: 'Eliminar requisito', action: @js(route('courses.requirements.destroy', [$course, 0])).replace('/0', '/' + req.id), payload: req };
        },
        closeModal() { this.modal.open = false; }
    }
}
</script>
@else
    <p class="text-sm text-gray-600">Crea primero el curso para poder agregar requisitos.</p>
@endif
