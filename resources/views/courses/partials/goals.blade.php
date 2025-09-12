@if(isset($course))
<div x-data="goalsManager()" x-init="init()" class="space-y-4">
    <div class="flex justify-end">
        <button @click="openCreate()" class="btn btn-primary">Nueva meta</button>
    </div>
    <ul class="divide-y rounded border bg-white" @dragover.prevent @drop="onDrop">
        @foreach($course->goals()->orderBy('position')->get() as $goal)
            <li class="flex items-center gap-2 p-2 cursor-move hover:bg-gray-50"
                draggable="true"
                @dragstart="onDragStart($event, {{ $goal->id }})"
                @dragover.prevent="onDragOver($event, $el)"
                data-id="{{ $goal->id }}">
                <span class="text-gray-400">≡</span>
                <span class="flex-1">{{ $goal->text }}</span>
                <div class="flex gap-2">
                    <button class="btn btn-xs" @click="openEdit({ id: {{ $goal->id }}, text: @js($goal->text) })">Editar</button>
                    <button class="btn btn-xs btn-error" @click="openDelete({ id: {{ $goal->id }}, text: @js($goal->text) })">Eliminar</button>
                </div>
            </li>
        @endforeach
        @if($course->goals()->count() === 0)
            <li class="p-3 text-sm text-gray-500">Aún no hay metas definidas.</li>
        @endif
    </ul>
    <div class="flex justify-end">
        <form x-ref="reorderForm" method="POST" action="{{ route('courses.goals.reorder', $course) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="order" :value="JSON.stringify(order)">
            <button type="submit" class="btn">Guardar orden</button>
        </form>
    </div>

    <!-- Modal daisyUI -->
    <dialog x-ref="goalModal" :open="modal.open" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg" x-text="modal.title"></h3>
            <template x-if="modal.type==='create' || modal.type==='edit'">
                <form :action="modal.action" method="POST" class="space-y-4 mt-3">
                    @csrf
                    <template x-if="modal.type==='edit'"><input type="hidden" name="_method" value="PUT"></template>
                    <input name="text" class="input input-bordered w-full" :value="modal.payload.text || ''" placeholder="Descripción de la meta" required>
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
                    <p>¿Eliminar la meta: <span class="font-medium" x-text="modal.payload.text"></span>?</p>
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
function goalsManager() {
    return {
        order: [],
        draggingId: null,
        modal: { open: false, type: null, title: '', action: '', payload: {} },
        init() {
            this.refreshOrder();
        },
        refreshOrder() {
            this.order = Array.from(document.querySelectorAll('[data-id]')).map(li => Number(li.dataset.id));
        },
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
            const mouseY = e.clientY;
            // reordenar por posición vertical
            items.sort((a,b)=> a.getBoundingClientRect().top - b.getBoundingClientRect().top);
            this.order = items.map(el => Number(el.dataset.id));
            this.$refs?.reorderForm?.scrollIntoView({behavior:'smooth', block:'nearest'});
        },
        openCreate() {
            this.modal = { open: true, type: 'create', title: 'Nueva meta', action: @js(route('courses.goals.store', $course)), payload: {} };
            this.$nextTick(()=> this.$refs.goalModal?.showModal());
        },
        openEdit(goal) {
            this.modal = { open: true, type: 'edit', title: 'Editar meta', action: @js(route('courses.goals.update', [$course, 0])) .replace('/0', '/' + goal.id), payload: goal };
            this.$nextTick(()=> this.$refs.goalModal?.showModal());
        },
        openDelete(goal) {
            this.modal = { open: true, type: 'delete', title: 'Eliminar meta', action: @js(route('courses.goals.destroy', [$course, 0])) .replace('/0', '/' + goal.id), payload: goal };
            this.$nextTick(()=> this.$refs.goalModal?.showModal());
        },
        closeModal() { this.modal.open = false; this.$refs.goalModal?.close(); }
    }
}
</script>
@else
    <p class="text-sm text-gray-600">Crea primero el curso para poder agregar metas.</p>
@endif
