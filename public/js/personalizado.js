(function ($) {

  $(".table-lista").on('click', '.form-excluir-registro', function (e) {
    e.stopPropagation();
    e.preventDefault();

    acaoExcluirRegistro(e);
  });

  $(".tab-content").on('click', '.form-excluir-registro', function (e) {
    e.stopPropagation();
    e.preventDefault();

    acaoExcluirRegistro(e);
  });

  function acaoExcluirRegistro(e) {
    Swal.fire({
      title: "Confirmar exclusão?",
      text: "Ao confirmar você estará excluindo o registro permanente!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Sim, confirmar!",
      cancelButtonText: "Não, cancelar!",
    }).then(function (result) {
      if (result.value) {
        // $(e.currentTarget).submit();
        let url = $(e.currentTarget).attr('action');
        let item_remove = $(e.currentTarget).parents('.tr-class');
        $.ajax({
          url: url,
          method: "DELETE",
          data: {
            '_token': token,
          },
          beforeSend: () => {
            Olimpus.preload();
          },
          success: function (data) {
            item_remove.remove()
            $.toast({
              heading: 'Exclusão',
              text: data.text,
              icon: 'success',
              allowToastClose: true,
              hideAfter: 3000,
              loaderBg: '#ff6849',
              position: 'top-right',
              stack: false
            })
          },
          complete: () => {
            Olimpus.preloadOff();
          },
          error: () => {
            Olimpus.preloadOff();
          }
        });
      }
    });
  }

  $(".table-lista").on('click', '.ativar_desativar_class', function (e) {
    e.stopPropagation();
    e.preventDefault();

    let element = $(e.currentTarget);
    let url = element.attr('href');;
    let texto = element.attr('data-texto');
    let title = element.attr('data-title');
    let item_tr = element.parents('.tr-class');

    Swal.fire({
      title: title,
      text: texto,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Sim, confirmar!",
      cancelButtonText: "Não, cancelar!",
    }).then(function (result) {
      if (result.value) {

        $.ajax({
          url: url,
          method: "POST",
          data: {
            '_token': token,
          },
          beforeSend: () => {
            Olimpus.preload();
          },
          success: function (data) {

            if (data.tipo == 'desativado') {
              item_tr.addClass('item-desativado')
              item_tr.find('.icon-class').remove()
              element.html(`<i class="fa-solid fa-check icon-class"></i>`)
              element.attr('title', 'Ativar')
              element.attr('data-original-title', 'Ativar')
              element.attr('data-texto', 'Ativar')
              element.attr('data-title', 'Deseja ativar a carteira?')
            } else {
              item_tr.removeClass('item-desativado')
              item_tr.find('.icon-class').remove()
              element.html(`<i class="fa-regular fa-circle-xmark icon-class"></i>`)
              element.attr('title', 'Desativar')
              element.attr('data-original-title', 'Desativar')
              element.attr('data-texto', 'Desativar')
              element.attr('data-title', 'Deseja desativar a carteira?')
            }

            $.toast({
              heading: data.title,
              text: data.text,
              icon: 'success',
              allowToastClose: true,
              hideAfter: 3000,
              loaderBg: '#ff6849',
              position: 'top-right',
              stack: false
            })
          },
          complete: () => {
            Olimpus.preloadOff();
            $('[data-toggle="tooltip"]').tooltip();
          },
          error: () => {
            Olimpus.preloadOff();
          }
        });
      }
    });
  });

  $(".table-lista").on('click', '.pagination-class .pagination a', function (e) {
    e.preventDefault();

    let url = $(this).attr('href');
    montaUrl(url + "&pesquisa=1", true)
  })

  $(".tab-content").on('click', '.pagination-class .pagination a', function (e) {
    e.preventDefault();

    let url = $(this).attr('href');
    montaUrl(url + "&pesquisa=1", true)
  })

  $(".search-form").on('submit', function (e) {
    e.preventDefault();
    e.stopPropagation();

    let url = $(this).attr('action');
    let table = $(this).attr('data-table');
    montaUrl(url, false, table)
  });

  $(".tab-content").on('submit', '.search-form-lista', function (e) {
    e.preventDefault();
    e.stopPropagation();

    let url = $(this).attr('action');
    let table = $(this).attr('data-table');
    montaUrl(url, false, table, '.search-form-lista');
  });

  function montaUrl(url, pagination = true, table = null, classe = '.search-form') {
    // Captura todos os campos do formulário
    var parametros = $(classe).serializeArray();

    // Filtra somente os campos preenchidos
    var parametrosFiltrados = parametros.filter(function (parametro) {
      return parametro.value.trim() !== '';
    });

    // Monta a string de query
    var queryString = $.param(parametrosFiltrados);

    if (queryString) {
      if (pagination) {
        url = url + '&' + queryString;
      } else {
        url = url + '?' + queryString;
      }
    }
    getTabela(url, table)
  }

  function getTabela(url, table = null) {
    if (!table) {
      table = 'table-lista'
    }

    $.ajax({
      url: url,
      method: "GET",
      beforeSend: () => {
        Olimpus.preload();
      },
      success: function (data) {
        $(`.${table}`).html('');
        $(`.${table}`).html(data);
      },
      complete: () => {
        Olimpus.preloadOff();
        $('[data-toggle="tooltip"]').tooltip()
      }
    });
  }

  const Olimpus = {
    /*
    Criar requisação ajax e exibe erros nos campos
    form = id do formulario
    route = rota para enviar
    routeToGo = rota para caso de sucesso
    **** ATENÇÃO Passar response com os dados necessario para exibir toast ******
    **** ATENÇÃO Colocar id nos campos para retornar as mensagens de erro nos campo ******
    **** ATENÇÃO Se o campo for array utilizar o id como: id='array0campo' ******
    */
    ajaxForm(form, route, routeToGo = null, callback = null) {
      var formData = new FormData($(`#${form}`)[0]);
      $.ajax(route, {
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: () => {
          Olimpus.preload();
        },
        success: function (response) {
          if (response) {
            if (response.title && response.text && response.icon) {
              $.toast({
                heading: response.title,
                text: response.text,
                position: 'top-right',
                loaderBg: '#ff6849',
                icon: response.icon,
                allowToastClose: true,
                hideAfter: 3000,
                stack: 10
              });
              if (response.icon == "success") {
                if (routeToGo != null) {
                  window.location = routeToGo;
                }
              }
            } else {
              if (routeToGo != null) {
                window.location = routeToGo;
              }
            }
          } else {
            if (routeToGo != null) {
              window.location = routeToGo;
            }
          }
          if (callback != null) {
            callback(response);
          }
        },
        complete: () => {
          if (routeToGo == null) {
            Olimpus.preloadOff();
          }
        },
        error: function (response) {
          $(".has-danger").removeClass('has-danger');
          $(".form-control-danger").removeClass('form-control-danger');
          $(".form-control-feedback").remove();
          if (response.responseJSON.icon) {
            $.toast({
              heading: response.responseJSON.title,
              text: response.responseJSON.text,
              position: 'top-right',
              loaderBg: '#ff6849',
              icon: response.responseJSON.icon,
              allowToastClose: true,
              hideAfter: 3000,
              stack: 10
            });
          }

          if (response.responseJSON.errors) {
            Object.keys(response.responseJSON.errors).forEach(function (key) {
              $.toast({
                heading: 'Erro',
                text: response.responseJSON.errors[key][0],
                position: 'top-right',
                loaderBg: '#ff6849',
                icon: 'error',
                allowToastClose: true,
                hideAfter: 3000,
                stack: 10
              });
              var html = `<div class="form-control-feedback">${response.responseJSON.errors[key][0]}</div>`
              var campo = key.replaceAll(".", "");
              var formGroup = $(`#${form}`).find(`#${campo}`).parents(".form-group");
              formGroup.append(html)
              formGroup.addClass('has-danger');
              $(`#${campo}`).addClass('form-control-danger');
            });
          }

          Olimpus.preloadOff();
        }
      })
    },

    preload() {
      $('.loading').css('display', 'block');
      $('.loading').find('.class-loading').addClass('loader')
    },

    preloadOff() {
      $('.loading').css('display', 'none');
      $('.loading').find('.class-loading').removeClass('loader');
    },

    retornaError(response) {
      $(".has-danger").removeClass('has-danger');
      $(".form-control-danger").removeClass('form-control-danger');
      $(".form-control-feedback").remove();
      if (response.responseJSON.errors) {
        Object.keys(response.responseJSON.errors).forEach(function (key) {
          $.toast({
            heading: 'Erro',
            text: response.responseJSON.errors[key][0],
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            allowToastClose: true,
            hideAfter: 3000,
            stack: 10
          });
          var html = `<div class="form-control-feedback">${response.responseJSON.errors[key][0]}</div>`
          var campo = key.replaceAll(".", "");
          var formGroup = $(`#${campo}`).parents(".form-group");
          formGroup.append(html)
          formGroup.addClass('has-danger');
          $(`#${campo}`).addClass('form-control-danger');
        });
      }

      if (response.responseJSON.icon) {
        $.toast({
          heading: response.responseJSON.title,
          text: response.responseJSON.text,
          position: 'top-right',
          loaderBg: '#ff6849',
          icon: response.responseJSON.icon,
          allowToastClose: true,
          hideAfter: 3000,
          stack: 10
        });
      }
    }
  }

  window.Olimpus = Olimpus;

  $(".content-body").on('blur', '#cep', function () {

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    getCEP(cep)
  });

  function getCEP(cep) {
    cep = cep.replace(/\D/g, ''); // Remove caracteres não numéricos
    if (cep.length === 8) {
        const url = `https://viacep.com.br/ws/${cep}/json/`;

        $.getJSON(url, function(data) {
            if (!data.erro) {
                $('#rua').val(data.logradouro);
                $('#bairro').val(data.bairro);
                $('#cidade').val(data.localidade);
                $('#estado').val(data.uf).change();
            } else {
                Swal.fire('CEP não encontrado.');
            }
        }).fail(function() {
            Swal.fire('Erro ao consultar o CEP. Tente novamente.');
        });
    } else {
        Swal.fire('Digite um CEP válido com 8 dígitos.');
    }
  }
})(jQuery);