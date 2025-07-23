const elemEmptyColumn = {
    settings:{
        id:'column_'+Date.now(),
        name:"Column",
        padding:{
            top:"",
            right:"",
            bottom:"",
            left:""
        },
        margin:{
            top:"",
            right:"",
            bottom:"",
            left:""
        },
        rounded:"",
        background:{
            color:"",
            dynamic:false,
            dynamic_image:"mainImage",
            image:null,
            position:"bg-center",
            size:"bg-cover",
            layer:{
                color:"",
                opacity:"opacity-50"
            }
        },
        size:{
            sm:"col-12",
            md:"",
            lg:"",
            xl:"",
        },
        asRow:false,
        rowGutter:{
            sm:"",
            md:"",
            lg:"",
            xl:"",
        },
        flexDirection:{
            sm:"flex-column",
            md:"",
            lg:"",
            xl:"",
        },
        sticky:false,
        class:"",
        display:{
            mobile:true,
            desktop:true
        }
    },
    elements:[],
};


const elemEmptyRow = {
    settings:{
        id:'row_'+Date.now(),
        name:"Row",
        margin:{
            top:"",
            right:"",
            bottom:"",
            left:""
        },
        rounded:"rounded-0",
        background:{
            color:"",
            image:null,
            position:"bg-center",
            size:"bg-cover",
            layer:{
                color:"",
                opacity:"opacity-50"
            }
        },
        class:"",
        display:{
            mobile:true,
            desktop:true
        },
        gutter:{
            sm:"",
            md:"",
            lg:"",
            xl:"",
        },
        alignContents:"",
        justifyContents:"",
        masonry:false,
        columnAsTabs:false,
        columnAsSlides:false,
        swiperOptions: {
            pagination:false,
            navigation:false,
            navigationPosition:'navigation-default',
            loop:false,
            spaceBetween:15,
            columnCounts:{
                sm:1,
                md:1,
                lg:1,
                xl:1
            },
            nextPrevVisibleArea:{
                sm:0,
                md:0,
                lg:0,
                xl:0
            },
        }
    },
    columns:[JSON.parse(JSON.stringify(elemEmptyColumn))]
};


const elemEmptyContainer = {
    settings:{
        id:'container_'+Date.now(),
        name:"Container",
        padding:{
            top:"",
            right:"",
            bottom:"",
            left:""
        },
        margin:{
            top:"",
            right:"",
            bottom:"",
            left:""
        },
        rounded:"rounded-0",
        background:{
            color:"",
            image:null,
            position:"bg-center",
            size:"bg-cover",
            layer:{
                color:"",
                opacity:"opacity-50"
            }
        },
        class:"",
        display:{
            mobile:true,
            desktop:true
        },
        fullWidth:false,
        largeContainer:false,
        rowsAsTabs:false,
    },
    rows:[JSON.parse(JSON.stringify(elemEmptyRow))]
};


const elemEmptySection = {
    settings:{
        id:'section_'+Date.now(),
        name:"Section",
        padding:{
            top:"",
            right:"",
            bottom:"",
            left:""
        },
        margin:{
            top:"",
            right:"",
            bottom:"",
            left:""
        },
        background:{
            color:"",
            parallax:false,
            image:null,
            position:"bg-center",
            size:"bg-cover",
            layer:{
                color:"",
                opacity:"opacity-50"
            }
        },
        shapeTop:{
            color:"",
            type:"wave",
            active:false,
        },
        shapeBottom:{
            color:"",
            type:"wave",
            active:false,
        },
        fadeInUp:false,
        class:"",
        display:{
            mobile:true,
            desktop:true
        },
        containerAsTabs:false,
        containerAsSlides:false,
    },
    containers:[JSON.parse(JSON.stringify(elemEmptyContainer))]
};

const addSection = (form) => {

    let emptySectionForAdd = JSON.parse(JSON.stringify(elemEmptySection));
    emptySectionForAdd.settings.id = 'section_'+Date.now();
    emptySectionForAdd.containers[0].settings.id = 'container_'+Date.now();
    emptySectionForAdd.containers[0].rows[0].settings.id = 'row_'+Date.now();
    emptySectionForAdd.containers[0].rows[0].columns[0].settings.id = 'column_'+Date.now();
    form.content.push(emptySectionForAdd);
}

const addContainer = (section) => {
    let emptyContainerForAdd = JSON.parse(JSON.stringify(elemEmptyContainer));
    emptyContainerForAdd.settings.id = 'container_'+Date.now();
    emptyContainerForAdd.rows[0].settings.id = 'row_'+Date.now();
    emptyContainerForAdd.rows[0].columns[0].settings.id = 'column_'+Date.now();
    section.containers.push(emptyContainerForAdd);
}

const addRow = (container) => {
    let emptyRowForAdd = JSON.parse(JSON.stringify(elemEmptyRow));
    emptyRowForAdd.settings.id = 'row_'+Date.now();
    emptyRowForAdd.columns[0].settings.id = 'column_'+Date.now();
    container.rows.push(emptyRowForAdd);
}

const addColumn = (row) => {
    let emptyColumnForAdd = JSON.parse(JSON.stringify(elemEmptyColumn));
    emptyColumnForAdd.settings.id = 'column_'+Date.now();
    row.columns.push(emptyColumnForAdd);
}

export {
    addSection,
    addContainer,
    addRow,
    addColumn
}