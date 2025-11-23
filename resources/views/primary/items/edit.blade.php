<x-crud.modal-edit-js title="Edit Item">
    <form method="POST" class="mt-4">
        <input type="hidden" name="id" id="edit_id">

        @include('primary.items.partials.dataform', ['form' => ['id' => 'Edit Item', 'mode' => 'edit']])


        <!-- Actions -->
        <div class="flex justify-end space-x-4 mt-4">
            <x-primary-button type="submit">{{ $form['id'] ?? 'Save' }}</x-primary-button>
            <button type="button" @click="isOpen = false"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700">Cancel</button>
        </div>
    </form>
</x-crud.modal-edit-js>
