update shipbuilding_tasks
set item_type = 'category'
where level < 3 and name in (
     'Engineering & Design',
     'Procurement',
     'Construction',
     'HULL & OUTFITTING',
     'PIPING','MECHANICAL',
     'ELECTRICAL',
     'CARPENTRY',
     'PAINTING',
     'Commisioning',
     'Legal Document'
);
