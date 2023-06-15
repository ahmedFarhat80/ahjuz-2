<td class="text-end">
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
      الإجراءات
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
      <li>
        <a href='{{ route('admin.conversations.show', $model->id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
          عرض المحادثة
        </a>
        @if ($model->property_id)
        <a href='{{ route('admin.properties.show', $model->property_id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
          عرض الوحدة
        </a>      
        @endif
        @if ($model->property->owner_id)
        <a href='{{ route('admin.owners.show', $model->property->owner_id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
          عرض المالك
        </a>      
        @endif
        @if ($model->customer_id)
        <a href='{{ route('admin.customers.show', $model->customer_id) }}' class="dropdown-item w-100 btn btn-sm btn-light btn-active-light-primary">
          عرض الزبون
        </a>      
        @endif
      </li>
    </ul>
  </div>
</td>
