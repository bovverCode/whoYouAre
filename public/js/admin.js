// admin js
function docReady(fn) {
  // see if DOM is already available
  if (document.readyState === "complete" || document.readyState === "interactive") {
      // call on next available tick
      setTimeout(fn, 1);
  } else {
      document.addEventListener("DOMContentLoaded", fn);
  }
}

docReady(function () {
  // Do ajax request.
  const ajaxSend = async (form, formData) => {
    const response = await fetch(form.action, {
      method: 'POST',
      body: formData
    });
    const info = await response.json();
    return info;
  };

  // Create select element
  const createSelect = (select_name, options) => {
    const select = document.createElement('select');
    select.name = select_name;
    let first = true;
    options.forEach(opt => {
      const option = document.createElement('option');
      option.value = opt;
      option.innerText = opt[0].toUpperCase() + opt.slice(1);
      if (first) {
        first = false;
        option.selected = true;
      }
      select.append(option);
    });
    return select;
  };

  const createTextarea = (name, cols, placeholder) => {
    const textarea = document.createElement('textarea');
    textarea.name = name;
    textarea.cols = cols;
    textarea.placeholder = placeholder;
    return textarea;
  };

  const createButton = (button_class, button_text) => {
    const wrap = document.createElement('div');
    wrap.classList.add('admin-button');
    const button = document.createElement('button');
    button.classList.add(button_class);
    button.innerText = button_text;
    wrap.append(button);
    return wrap;
  };

  // Create group form
  const addGroupForm = document.getElementById('add-group');
  if (addGroupForm) {
    const listParent = addGroupForm.querySelector('.error-list');
    const groupTableBody = document.querySelector('.fields__table tbody');

    function addError(errors) {
      listParent.childNodes.forEach(n => n.remove());
      errors.forEach(error => {
        const el = document.createElement('li');
        el.innerText = error;
        listParent.append(el);
      });
    }

    function addGroup(name, id) {
      const tr = document.createElement('tr');
      const td = document.createElement('td');
      const text = document.createElement('h4');
      text.innerText = name;
      td.append(text)
      const td2 = document.createElement('td');
      const link = document.createElement('a');
      link.innerText = 'Edit';
      link.href = '/admin/fields/group/' + id;
      td2.append(link);
      tr.append(td, td2);
      groupTableBody.append(tr);
    }

    addGroupForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData();
      formData.append('group_name', addGroupForm.querySelector('input[name="group_name"]').value);
      ajaxSend(addGroupForm, formData).then(res => {
        if (res.error) {
          addError(res.error);
        } else if (res.success) {
          addGroup(res.success.name, res.success.id);
        }
      })
    });
  }

  // Group fields app
  const fieldsApp = document.getElementById('group-app');
  if (fieldsApp) {
    const addFieldButton = fieldsApp.querySelector('#add-field');
    const types = fieldsApp.dataset.types.split(',');
    const fieldsBody = fieldsApp.querySelector('.group-app__table tbody');

    function createField() {
      const tr = document.createElement('tr');
      tr.classList.add('field-row', 'field-row--new');

      const slugTd = document.createElement('td');
      slugTd.classList.add('field_slug');
      const slugInput = document.createElement('input');
      slugInput.placeholder = 'Field slug';
      slugInput.type = 'text';
      slugInput.name = 'field_slug';
      slugTd.append(slugInput)

      const typeTd = document.createElement('td');
      typeTd.classList.add('field_type');
      const typeSelect = createSelect('field_type', types);
      typeTd.append(typeSelect);

      const valueTd = document.createElement('td');
      valueTd.classList.add('field_value');
      const valueTextArea = createTextarea('field_value', 6, 'Text content');
      valueTd.append(valueTextArea);

      const actionTd = document.createElement('td');
      const button = createButton('delete-field', 'Delete');
      actionTd.append(button);

      tr.append(slugTd, typeTd, valueTd, actionTd);
      fieldsBody.append(tr);
    }

    addFieldButton.addEventListener('click', function (e) {
      e.preventDefault();
      createField();
    });

    fieldsApp.addEventListener('submit', function (e) {
      e.preventDefault();
    });
  }
});



