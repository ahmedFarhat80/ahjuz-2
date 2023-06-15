<td class="text-end">
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      الإجراءات
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li>
        <a href='{{ $model->url }}' target="_blank" class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
            عرض رابط الإعلان
        </a>
        <a href='{{ route('admin.ads.show', $model->id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
            تعديل الإعلان
        </a>
        <form method="POST" action='{{ route('admin.ads.destroy', $model->id) }}'
          class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary" data-kt-ad-table-filter="delete_row">
            @csrf @method('DELETE') 
            حذف الإعلان
        </form>
      </li>
    </ul>
  </div>
</td>
