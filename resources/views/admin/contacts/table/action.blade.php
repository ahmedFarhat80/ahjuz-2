<td class="text-end">
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      الإجراءات
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li>
        <a href='{{ route('admin.contacts.show', $model->id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
            عرض الرسالة
        </a>
        <form method="POST" action='{{ route('admin.contacts.destroy', $model->id) }}'
          class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary" data-kt-contact-table-filter="delete_row">
            @csrf @method('DELETE') 
            حذف الرسالة
        </form>
      </li>
    </ul>
  </div>
</td>
