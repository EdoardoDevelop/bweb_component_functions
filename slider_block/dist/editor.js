( function( blocks, element, components) {

  var el = element.createElement,
  registerBlockType = blocks.registerBlockType,
  InspectorControls = wp.blockEditor.InspectorControls,
  InspectorAdvancedControls = wp.blockEditor.InspectorAdvancedControls,
  Fragment = element.Fragment,
  useBlockProps = wp.blockEditor.useBlockProps,
  AlignmentMatrixControl = components.__experimentalAlignmentMatrixControl,
  FocalPointPicker = components.FocalPointPicker,
  MediaUpload =  wp.blockEditor.MediaUpload,
  MediaUploadCheck =  wp.blockEditor.MediaUploadCheck,
  ColorPalette = components.ColorPalette,
  ToolbarButton = components.ToolbarButton,
  Modal = components.Modal,
  useState = element.useState,
  useEffect = element.useEffect,
  useRef = element.useRef,
  BlockControls = wp.blockEditor.BlockControls,
  TabPanel = components.TabPanel,
  Toolbar = components.Toolbar,
  ToolbarGroup  = components.ToolbarGroup,
  ToolbarDropdownMenu = components.ToolbarDropdownMenu,
  TextControl  = components.TextControl,
  TextareaControl = components.TextareaControl,
  PanelBody = components.PanelBody,
  SelectControl = components.SelectControl,
  CheckboxControl = components.CheckboxControl,
  Button = components.Button,
  UnitControl = components.__experimentalUnitControl,
  RadioControl = components.RadioControl,
  InnerBlocks = wp.blockEditor.InnerBlocks;

  

  function MyMediaUploader({ mediaIDs, onSelect, toolbar = false }) {
    return el(MediaUploadCheck, null, el(MediaUpload, {
      onSelect: onSelect,
      allowedTypes: [ 'image' ],
      value: mediaIDs,
      render: ({
        open
      }) => el(Button, {
        icon: 'insert',
        variant: "secondary",
        onClick: open,
        className: toolbar ? '' : "button button-large"
      }, 'Aggiungi/Modifica'),
      gallery: true,
      multiple: true
    }));
  }

  function animation(mode){
    var effect = mode;
    var creativeEffect = {};
    var directionvertical = true;

    switch(mode) {
      case 'fade':
        directionvertical = false;
        break;
      case 'creative1':
        effect = 'creative';
        creativeEffect = {
          prev: {
            shadow: true,
            translate: [0, 0, -400],
          },
          next: {
            translate: ["100%", 0, 0],
          }
        };
        directionvertical = false;
        break;
      case 'creative2':
        effect = 'creative';
        creativeEffect = {
          prev: {
            opacity: 0,
            translate: [0, 0, -100],
          },
          next: {
            opacity: 0,
          }
        };
        directionvertical = false;
        break;
      case 'creative3':
        effect = 'creative';
        creativeEffect = {
          prev: {
            opacity: 0,
            translate: [0, 0, 100],
          },
          next: {
            opacity: 0,
          }
        };
        directionvertical = false;
        break;
      case 'creative4':
        effect = 'creative';
        creativeEffect = {
          prev: {
            shadow: true,
            translate: ["-20%", 0, -1],
          },
          next: {
            translate: ["100%", 0, 0],
          }
        };
        directionvertical = false;
        break;
      
    }
    return{
      effect : effect,
      creativeEffect: creativeEffect,
      directionvertical: directionvertical
    }
  }
  
  function alignText(v){
    var alignText = {}; 
    switch(v) {
      case 'top left':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '20px',
          left: '50px',
          transform:'translate(0,0)'
        };
        break;
      case 'top center':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '20px',
          left: '50%',
          transform:'translateX(-50%)'
        };
        break;
      case 'top right':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '20px',
          right: '50px',
          transform:'translate(0,0)'
        };
        break;
      case 'center left':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '50%',
          left: '50px',
          transform:'translateY(-50%)'
        };
        break;
      case 'center center':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '50%',
          left: '50%',
          transform:'translate(-50%,-50%)'
        };
        break;
      case 'center right':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          top: '50%',
          right: '50px',
          transform:'translateY(-50%)'
        };
      break;
      case 'bottom left':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          bottom: '20px',
          left: '50px',
          transform:'translate(0,0)'
        };
        break;
      case 'bottom center':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          bottom: '20px',
          left: '50%',
          transform:'translateX(-50%)'
        };
        break;
      case 'bottom right':
        alignText = {
          position: 'absolute',
          'z-index': '2',
          color: 'white',
          bottom: '20px',
          right: '50px',
          transform:'translate(0,0)'
        };
        break;
    }
    return alignText;
  }

  
	registerBlockType( 'bc/slide', {
    apiVersion: 2,
    title: 'BC Slide',
    icon: 'slides',
    category: 'bweb-component',
    
    "supports": {
      "align": [ 'wide', 'full' ]
    },
    attributes: {
      'regeventDOM': {
				type: 'boolean',
        default: 0
			},
      'blockID': {
				type: 'string',
        default: '0'
			},
			'mode': {
				type: 'string',
        default: 'slide'
			},
      'loop': {
        type: 'boolean',
        default: 1
      },
      'speed': {
        type: 'string',
        default: '600'
      },
      'autoplay': {
        type: 'boolean',
        default: 0
      },
      'delay': {
        type: 'string',
        default: 3000
      },
      'direction': {
        type: 'string',
        default: 'horizontal'
      },
      'valueH': {
        type: 'string',
        default: '500px'
      },
      'Overlaycolor': {
        type: 'string',
        default: 'rgba(0, 0, 0, 0.47)'
      },
      'isTextShow': {
        type: 'boolean',
        default: 1
      },
      'Textalignment': {
        type: 'string',
        default: 'center center'
      },
      'arrowShow':{
        type: 'boolean',
        default: 1
      },
      'pointerShow':{
        type: 'boolean',
        default: 0
      },
      'pointerType':{
        type: 'string',
        default: 'square'
      },
      'navpointcolor': {
        type: 'string',
        default: '#007aff'
      },
      'option': {
        type: 'string',
        default: ''
      },
      
      'images': {
        type: 'array',
        source: 'query',
        selector: '.swiper-slide',
        default: [],
  
        query: {
          focalPointX:{
            type: 'string',
            source: 'attribute',
            attribute: 'data-focalpointx',
            selector: 'img',
          },
          focalPointY:{
            type: 'string',
            source: 'attribute',
            attribute: 'data-focalpointy',
            selector: 'img',
          },
          countI: {
            type: 'number',
            source: 'attribute',
            attribute: 'data-count',
            selector: 'img',
          },
          mediaID: {
            type: 'number',
            source: 'attribute',
            attribute: 'data-id',
            selector: 'img',
          },
          mediaURL: {
            type: 'string',
            source: 'attribute',
            attribute: 'src',
            selector: 'img',
          },
          thumbnail: {
            type: 'string',
            source: 'attribute',
            attribute: 'data-thumb',
            selector: 'img',
          },
        },
      },
    },


    edit: function( props ) {
      var blockID = props.attributes.blockID,
      mode = props.attributes.mode,
      loop = props.attributes.loop,
      speed = props.attributes.speed,
      autoplay = props.attributes.autoplay,
      delay = props.attributes.delay,
      direction = props.attributes.direction,
      valueH = props.attributes.valueH,
      images = props.attributes.images,
      Overlaycolor = props.attributes.Overlaycolor,
      isTextShow = props.attributes.isTextShow,
      Textalignment = props.attributes.Textalignment,
      arrowShow = props.attributes.arrowShow,
      pointerShow = props.attributes.pointerShow,
      pointerType = props.attributes.pointerType,
      navpointcolor = props.attributes.navpointcolor,
      option = props.attributes.option;

      const swiperRef = useRef(null);

      const [ isOpen, setOpen ] = useState( false );
      const openModal = () => setOpen(true);
      const closeModal = () => setOpen(false);

      const unitsH = [
          { value: 'px', label: 'px', default: 0 },
          { value: '%', label: '%', default: 10 },
          { value: 'vh', label: 'vh', default: 0 },
      ];
      const onSelect = items => {
        var countI = 0;
        props.setAttributes({
          images: items.map(item => {
            countI++;
            //console.log(item);
            return {
              focalPointX:"0.5",
              focalPointY:"0.5",
              countI: countI,
              mediaID: parseInt(item.id, 10),
              mediaURL: item.sizes.image_HD.url,
              thumbnail: item.sizes.thumbnail.url
            };
          })
        });
        props.setAttributes({ regeventDOM : props.attributes.regeventDOM ? 0 : 1 });
      };
      
      var blockPropsCarousel = useBlockProps({
        className: 'bc_slide',
        style:{'height': valueH}
      });
      
      if(blockID==0){
        props.setAttributes({ blockID : blockPropsCarousel.id });
      }

      useEffect(() => {
        if (swiperRef.current && swiperRef.current.initialized) {
          // Destroy Swiper instance when updating.
          swiperRef.current.destroy(true, true);
        }
        swiperRef.current = new Swiper('#'+blockPropsCarousel.id+' .swiper', {
          direction: animation(mode)['directionvertical'] ? direction : 'horizontal', 
          speed: speed, 
          loop: loop, 
          effect: animation(mode)['effect'],
          navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }, 
          pagination: { el: '.swiper-pagination', type: 'bullets', clickable: true },
          on: {
            init: function () {
              console.log(blockPropsCarousel.id);
              
              jQuery('#'+blockPropsCarousel.id+' .swiper').css("--swiper-navigation-color",navpointcolor);
              jQuery('#'+blockPropsCarousel.id+' .swiper').css("--swiper-pagination-color",navpointcolor);
              jQuery('#'+blockPropsCarousel.id+' .swiper').css("--swiper-pagination-bullet-inactive-color",navpointcolor);
              jQuery('#'+blockPropsCarousel.id+' .swiper').css("--swiper-pagination-bullet-inactive-opacity","0.4");
            }
          },
          creativeEffect: animation(mode)['creativeEffect'],
          option
        });

        setTimeout(() => {
          swiperRef.current.slideNext(speed);
          swiperRef.current.on('transitionEnd', function () {
            setTimeout(() => {
              swiperRef.current.slidePrev(speed,false);
              swiperRef.current.off('transitionEnd');
            }, 300);
            
          });
        }, 300);

      }, [mode, loop, speed, direction, arrowShow, pointerShow, navpointcolor, props.attributes.align, props.attributes.regeventDOM]);

      const TEMPLATE = [ 
        [ 'core/heading', { placeholder: 'Enter title...',fontSize: 'large','textColor': 'white' } ],
        [ 'core/paragraph', { placeholder: 'Enter side content...', 'textColor': 'white' } ]
      ];
      
      
      return (
                
        el( Fragment, {},
            
          el( InspectorControls, {},
            el(TabPanel, {
              className: "bcslide-tab-panel",
              tabs: [{
                name: 'images',
                title: 'Immagini',
                className: 'bcslide-tab-images',
                icon: 'format-gallery'
              }, {
                name: 'settings',
                title: 'Impostazioni',
                className: 'bcslide-tab-settings',
                icon: 'admin-generic'
              }, {
                name: 'appearance',
                title: 'Aspetto',
                className: 'bcslide-tab-appearance',
                icon: 'admin-appearance'
              }],
              children: tab => 
              {
                if(tab.name=='images'){
                  return el('div',{},
                    el(PanelBody,{},
                        el(MyMediaUploader, {
                        mediaIDs: images.map(item => item.mediaID),
                        onSelect: onSelect
                      }),
                      el(Button, {
                        className: "button button-small",
                        onClick: openModal,
                        children: "Posizionamento immagini",
                        style:{
                          "margin-top":"15px"
                        }
                      }),
                      isOpen ?
                      el(Modal, {
                          title: "Posizionamento immagini",
                          onRequestClose: closeModal,
                          children: 
                          images.map(item =>
                            el("div",{
                                className: "item_focalpointpicker"+item.countI,
                                style:{
                                  width: "200px",
                                  display: "inline-block",
                                  margin: "5px"
                                }
                              },
                              el(FocalPointPicker,{
                                url: item.mediaURL,
                                value: {x:Number(item.focalPointX),y:Number(item.focalPointY)},
                                
                                onChange: ( value ) => {
                                  
                                  setTimeout(() => {
                                    document.querySelector('.components-modal__screen-overlay').classList.remove("drag_modal_background");
                                    document.querySelector('.components-modal__frame').classList.remove("drag_modal_background");
                                    document.querySelector('.components-modal__header').classList.remove("drag_modal_opacity");
                                    document.querySelector('.components-modal__content').classList.remove("drag_modal_opacity");
                                    document.querySelectorAll('.components-modal__content > div').forEach(element => {
                                      if(!element.classList.contains("item_focalpointpicker"+item.countI)){
                                        element.classList.remove("drag_modal_opacity");
                                      }else{
                                        element.querySelector('.focal-point-picker__controls').classList.remove("drag_modal_opacity");
                                      }
                                    });
                                  }, 800);
                                  
                                },
                                onDrag: (value) => {
                                  props.setAttributes({
                                    images: images.map(img => {
                                      if(img.mediaURL==item.mediaURL){
                                        img.focalPointX = String(value.x);
                                        img.focalPointY = String(value.y);
                                      }
                                      return img;
                                    })
                                  });
                                  
                                  swiperRef.current.slideTo(item.countI-1);
                                  document.querySelector('.components-modal__screen-overlay').classList.add("drag_modal_background");
                                  document.querySelector('.components-modal__frame').classList.add("drag_modal_background");
                                  document.querySelector('.components-modal__header').classList.add("drag_modal_opacity");
                                  //document.querySelector('.components-modal__content *').classList.add("drag_modal_opacity");
                                  document.querySelectorAll('.components-modal__content > div').forEach(element => {
                                    if(!element.classList.contains("item_focalpointpicker"+item.countI)){
                                      element.classList.add("drag_modal_opacity");
                                    }else{
                                      element.querySelector('.focal-point-picker__controls').classList.add("drag_modal_opacity");
                                    }
                                    
                                  });
                                }
                              })
                            )
                          )

                      })
                      :null

                    )
                  )
                };
                if(tab.name=='settings'){
                  return el('div',{},
                    el(PanelBody,{title: 'Animazione'},
                      el(SelectControl,{
                        value: mode,
                        options: [
                            {
                                "value": "slide",
                                "label": "Slide"
                            },
                            {
                                "value": "fade",
                                "label": "Fade"
                            },
                            {
                                "value": "flip",
                                "label": "Flip"
                            },
                            {
                                "value": "cube",
                                "label": "Cube"
                            },
                            {
                                "value": "cards",
                                "label": "Cards"
                            },
                            {
                                "value": "coverflow",
                                "label": "Coverflow"
                            },
                            {
                                "value": "creative1",
                                "label": "Slide/Zoom out"
                            },
                            {
                                "value": "creative2",
                                "label": "Fade/Zoom out"
                            },
                            {
                                "value": "creative3",
                                "label": "Fade/Zoom in"
                            },
                            {
                                "value": "creative4",
                                "label": "Slide/Parallax"
                            }
                        ],
                        onChange: ( value ) => {
                          props.setAttributes( { mode: value } );
                        },
                      }),
                      animation(mode)['directionvertical'] ? el(RadioControl, {
                        label: "Direzione",
                        selected: direction,
                        options: [{
                          label: 'Orizzontale',
                          value: 'horizontal'
                        },{
                          label: 'Verticale',
                          value: 'vertical'
                        }],
                        onChange: ( value ) => {
                          props.setAttributes( { direction: value } );
                        }
                      }):null,
                      el(TextControl,{
                        label: 'Velocità animazione (ms)',
                        value: speed,
                        type: 'number',
                        onChange: ( value ) => {
                            props.setAttributes( { speed: value } );
                          
                        },
                      })
                    ),
                    el(PanelBody,{title: 'Autoplay'},
                      el(CheckboxControl,{
                        label: 'Abitilia',
                        checked: autoplay,
                        onChange: ( value ) => {
                          props.setAttributes( { autoplay: value } );
                        },
                      }),
                      autoplay ? el(TextControl,{
                        label: 'Delay (ms)',
                        value: delay,
                        type: 'number',
                        onChange: ( value ) => {
                          props.setAttributes( { delay: value } );
                        },
                      }):null
                    ),
                    el(PanelBody,{title: 'Loop'},
                      el(CheckboxControl,{
                        label: 'Abitilia',
                        checked: loop,
                        onChange: ( value ) => {
                            props.setAttributes( { loop: value } );
                        },
                      })
                    ),
                    el(PanelBody,{title: 'Testo'},
                      el(CheckboxControl,{
                        label: 'Visibile',
                        checked: isTextShow,
                        onChange: ( value ) => {
                            props.setAttributes( { isTextShow: value } );
                        },
                      }),
                      isTextShow ? el(AlignmentMatrixControl, {
                        label: 'Posizione testo',
                        value: Textalignment,
                        onChange: ( value ) => {
                          props.setAttributes( { Textalignment: value } );
                        },
                      }):null
                    ),
                    
                    el(PanelBody,{},
                      el(UnitControl, {
                        label: 'Altezza',
                        className: 'w-UnitControl',
                        value: valueH,
                        units: unitsH,
                        onChange : ( value ) => {
                          props.setAttributes( { valueH: value } );
                        },
                      })
                    )
                  )
    
                  
                };
                if(tab.name=='appearance'){
                  return el('div',{},
                    el(PanelBody,{title: 'Frecce'},
                      el(CheckboxControl,{
                        label: 'Abilita',
                        checked: arrowShow,
                        onChange: ( value ) => {
                            props.setAttributes( { arrowShow: value } );
                        },
                      }),

                    ),
                    el(PanelBody,{title: 'Indicatori'},
                      el(CheckboxControl,{
                        label: 'Abilita',
                        checked: pointerShow,
                        onChange: ( value ) => {
                            props.setAttributes( { pointerShow: value } );
                        },
                      }),
                      pointerShow ? el(RadioControl, {
                        label: "Tipologia",
                        selected: pointerType,
                        options: [{
                          label: 'Square',
                          value: 'square'
                        },{
                          label: 'Circle',
                          value: 'circle'
                        }],
                        onChange: ( value ) => {
                          props.setAttributes( { pointerType: value } );
                        }
                      }):null
                    ),
                    el(PanelBody,{title: 'Colore'},
                      el(ColorPalette , {
                        label: 'Colore',
                        value: navpointcolor,
                        enableAlpha: false,
                        onChange : ( value ) => {
                          props.setAttributes( { navpointcolor: value } );
                      },
                      })
                    ),
                    el(PanelBody,{title: 'Sovrapposizione'},
                      el(ColorPalette , {
                        label: 'Overlay',
                        value: Overlaycolor,
                        enableAlpha: true,
                        onChange : ( value ) => {
                          props.setAttributes( { Overlaycolor: value } );
                      },
                      })
                    ),
                  )
                };
              }
            }),


          ),
          el(
            BlockControls,
            { key: 'controls' },
            el(ToolbarGroup, {}, 
              el(MyMediaUploader, {
                mediaIDs: images.map(item => item.mediaID),
                onSelect: onSelect,
                toolbar: true
              }),
              
              el(ToolbarDropdownMenu,{
                title: 'Altezza',
                icon: 'editor-expand',
                controls: [
                  {
                    title: 'Altezza piena',
                    icon: 'align-full-width',
                    onClick : ( value ) => {
                      props.setAttributes( { valueH: '100vh' } );
                    }
                  },
                  {
                    title: '500px',
                    icon: 'align-wide',
                    onClick : ( value ) => {
                      props.setAttributes( { valueH: '500px' } );
                    }
                  }
                ]
              }),
              isTextShow ? el(ToolbarDropdownMenu,{
                title: 'Posizione testo',
                icon: AlignmentMatrixControl.Icon,
                children: ({
                  onClose
                }) =>
                  el(AlignmentMatrixControl, {
                    value: Textalignment,
                    onChange: ( value ) => {
                      props.setAttributes( { Textalignment: value } );
                    },
                  })
                
              }):null
            ),
          ),
          el(InspectorAdvancedControls,{},
            el(TextControl,{
              label: 'ID slide',
              value: blockID,
              onChange: ( value ) => {
                props.setAttributes( { blockID: value } );
                
              },
            }),
            el(TextareaControl,{
              label: 'Opzioni aggiuntivi',
              value: option,
              onChange: ( value ) => {
                props.setAttributes( { option: value } );
                
              },
            })
          ),
          el("div", blockPropsCarousel, 
            el("div",{
              className: "swiper",
              style:{
                "--swiper-navigation-color": navpointcolor,
                "--swiper-pagination-color": navpointcolor,
                "--swiper-pagination-bullet-inactive-color": navpointcolor,
                "--swiper-pagination-bullet-inactive-color": navpointcolor,
                "--swiper-pagination-bullet-inactive-opacity": '0.4'
              }
            },
            el("div", {
              className: "swiper-wrapper"
              }, 
              images.map(item => el("div", 
                {
                  className: "swiper-slide",
                  key: 'image-' + item.mediaID
                }, 
                el("img", 
                  {
                    src: item.mediaURL,
                    style:{
                      "object-position": Number(item.focalPointX) * 100 + "% " + Number(item.focalPointY) * 100 + "%"
                    }
                  }
                )
              )),
              
            ),
            images.length == 0 ? el("div", {
              style:{
                position: 'absolute',
                top: '50%',
                left: '50%',
                transform: 'translate(-50%, -50%)',
                'z-index': '9999'
              }
            }, el(MyMediaUploader, {
              mediaIDs: images.map(item => item.mediaID),
              onSelect: onSelect,
              toolbar: true
            })
            ):null,

            images.length >= 1 ? el("div",{
                className: 'swiper-overlay',
                style:{'background-color': Overlaycolor}
              }):null,
              images.length >= 1 ? isTextShow ? el("div",{
                className: 'caption',
                style:alignText(Textalignment)
              },el(InnerBlocks,{
                "title": "Caption",
                template: TEMPLATE,
                allowedBlocks: ['core/paragraph','core/heading','core/button'],
                orientation: "vertical"
                
              })):null:null,
              images.length >= 1 ? arrowShow ? el("div",{
                className : "swiper-button-prev"
                }
              ):null:null,
              images.length >= 1 ? arrowShow ? el("div",{
                className : "swiper-button-next"
                }
              ):null:null,
              images.length >= 1 ? pointerShow ?  el("div",{
                  className: "swiper-pagination " + pointerType
                }
              ):null:null,

            )
          ),
          
        )
              
      )
    },

    save: function(props) {
      
      var blockPropscarousel = useBlockProps.save({
        className: 'bc_slide swiper',
        id : props.attributes.blockID,
        'data-ride': 'swiper',
        style:{
          'height': props.attributes.valueH,
          "--swiper-navigation-color": props.attributes.navpointcolor,
          "--swiper-pagination-color": props.attributes.navpointcolor,
          "--swiper-pagination-bullet-inactive-color": props.attributes.navpointcolor,
          "--swiper-pagination-bullet-inactive-color": props.attributes.navpointcolor,
          "--swiper-pagination-bullet-inactive-opacity": '0.4'
        }
      });
      var animdirection = animation(props.attributes.mode)['directionvertical'] ? props.attributes.direction : 'horizontal';
      var autoplay = props.attributes.autoplay ? "autoplay: {delay: "+props.attributes.delay+",disableOnInteraction: false,pauseOnMouseEnter: true}," :"";
      return el("div", blockPropscarousel, el("div", {
        className: "swiper-wrapper"
      }, 
        props.attributes.images.map(item => el("div", 
          {
            className:  item.countI == 1 ? "swiper-slide active" : "swiper-slide",
            key: 'image-' + item.mediaID
          }, 
          el("img", 
            {
              "data-focalpointx": String(item.focalPointX),
              "data-focalpointY": String(item.focalPointY),
              'data-count': item.countI,
              src: item.mediaURL,
              "data-id": item.mediaID,
              "data-thumb": item.thumbnail,
              style:{
                "object-position": Number(item.focalPointX) * 100 + "% " + Number(item.focalPointY) * 100 + "%"
              }
            }
          )
        )),
        ),
        el("div",{
          className: 'swiper-overlay',
          style:{'background-color': props.attributes.Overlaycolor}
        }),
        props.attributes.isTextShow ? el("div",{className:'container container-swiper-caption'},el("div",{className:'swiper-caption',style:alignText(props.attributes.Textalignment)},el(InnerBlocks.Content))):null,
        props.attributes.arrowShow ? el("div",{
          className : "swiper-button-prev"
          }
        ):null,
        props.attributes.arrowShow ? el("div",{
          className : "swiper-button-next"
          }
        ):null,
        /*props.attributes.pointerShow ?  el("ol",{
            className: "swiper-pagination " + props.attributes.pointerType
          },
          props.attributes.images.map(item => el("li", 
              {
                className: item.countI == 1 ? "active" : "",
                "data-target": "#"+blockPropscarousel.id,
                "data-slide-to": item.countI - 1
              }
            )
          )
        ):null*/
        props.attributes.pointerShow ?  el("div",{
          className: "swiper-pagination " + props.attributes.pointerType
        }
      ):null,
      
      el("script",{},"new Swiper('#"+blockPropscarousel.id+"', {"+autoplay+" direction: '"+animdirection+"', speed: "+props.attributes.speed+", loop: "+props.attributes.loop+", effect: '"+animation(props.attributes.mode)['effect']+"',navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev', }, pagination: { el: '.swiper-pagination', type: 'bullets', clickable: true },creativeEffect: "+JSON.stringify(animation(props.attributes.mode)['creativeEffect'])+ props.attributes.option +"});")

      );
      
    }



  })
  
} )( window.wp.blocks, window.wp.element, window.wp.components );
