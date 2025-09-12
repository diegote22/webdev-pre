@if(isset($course))
<div x-data="reqsManager()" x-init="init()" class="space-y-4">
    <div class="flex justify-end">
        <button @click="openCreate()" class="btn btn-primary">Nuevo requisito</button>
    </div>
    <ul class="divide-y rounded border bg-white" @dragover.prevent @drop="onDrop">
        @foreach($course->requirements()->orderBy('position')->get() as $req)
            <li class="flex items-center gap-2 p-2 cursor-move hover:bg-gray-50" draggable="true" @dragstart="onDragStart($event, {{ $req->id }})" @dragover.prevent="onDragOver($event, $el)" data-id="{{ $req->id }}">
                <span class="text-gray-400">≡</span>
                <span class="flex-1">{{ $req->text }}</span>
                <div class="flex gap-2">
                    <button class="btn btn-xs" @click="openEdit({ id: {{ $req->id }}, text: @js($req->text) })">Editar</button>
                    <button class="btn btn-xs btn-error" @click="openDelete({ id: {{ $req->id }}, text: @js($req->text) })">Eliminar</button>
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

    <!-- Modal daisyUI -->
    <dialog x-ref="reqModal" :open="modal.open" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg" x-text="modal.title"></h3>
            <template x-if="modal.type==='create' || modal.type==='edit'">
                <form :action="modal.action" method="POST" class="space-y-4 mt-3">
                    @csrf
                    <template x-if="modal.type==='edit'"><input type="hidden" name="_method" value="PUT"></template>
                    <input name="text" class="input input-bordered w-full" :value="modal.payload.text || ''" placeholder="Descripción del requisito" required>
                    <div class="modal-action">
                        <button type="button" @click="closeModal()" class="btn">Cancelar</button>
                        <button class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </template>
            <template x-if="modal.type==='delete'">
                <form :action="modal.action" method="POST" class="space-y-4 mt-3">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <p>¿Eliminar el requisito: <span class="font-medium" x-text="modal.payload.text"></span>?</p>
                    <div class="modal-action">
                        <button type="button" @click="closeModal()" class="btn">Cancelar</button>
                        <button class="btn btn-error">Eliminar</button>
                    </div>
                </form>
            </template>
            <form method="dialog" class="modal-backdrop">
                <button @click="closeModal()">close</button>
            </form>
        </div>
    </dialog>
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
        openCreate() { this.modal = { open: true, type: 'create', title: 'Nuevo requisito', action: @js(route('courses.requirements.store', $course)), payload: {} }; this.$nextTick(()=> this.$refs.reqModal?.showModal()); },
        openEdit(req) {
            this.modal = { open: true, type: 'edit', title: 'Editar requisito', action: @js(route('courses.requirements.update', [$course, 0])).replace('/0', '/' + req.id), payload: req }; this.$nextTick(()=> this.$refs.reqModal?.showModal());
        },
        openDelete(req) {
            this.modal = { open: true, type: 'delete', title: 'Eliminar requisito', action: @js(route('courses.requirements.destroy', [$course, 0])).replace('/0', '/' + req.id), payload: req }; this.$nextTick(()=> this.$refs.reqModal?.showModal());
        },
        closeModal() { this.modal.open = false; this.$refs.reqModal?.close(); }
    }
}
</script>
@else
    <p class="text-sm text-gray-600">Crea primero el curso para poder agregar requisitos.</p>
@endif
