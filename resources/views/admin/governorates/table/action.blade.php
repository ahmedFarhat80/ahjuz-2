<td class="text-end">
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      الإجراءات
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li>
        <a href='{{ route('admin.governorates.show', $model->id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
            عرض المحافظة
        </a>
        <form method="POST" action='{{ route('admin.governorates.destroy', $model->id) }}'
          class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary" data-kt-governorate-table-filter="delete_row">
            @csrf @method('DELETE') 
            حذف المحافظة
        </form>
      </li>
    </ul>
  </div>
</td>
