<td class="text-end">
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      الإجراءات
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li>
        <a href='{{ route('admin.properties.show', $model->id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
            عرض الوحدة
        </a>
        @if ($model->owner_id)
        <a href='{{ route('admin.owners.show', $model->owner_id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
          عرض المالك
        </a>      
        @endif
        <form method="POST" action='{{ route('admin.properties.destroy', $model->id) }}'
          class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary" data-kt-property-table-filter="delete_row">
            @csrf @method('DELETE') 
            حذف الوحدة
        </form>
      </li>
    </ul>
  </div>
</td>
