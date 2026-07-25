const faDigits=['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
const toFa=s=>String(s).replace(/\d/g,d=>faDigits[d]);

//این قسمت در nav، روی $item->badge تابع toFa را اعمال میکند
document.querySelectorAll('.dynamic-badge').forEach(el => {
    const rawValue = el.getAttribute('data-value');
    el.textContent = toFa(rawValue);
});

const icons={
  dashboard:'<path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/>',
  patients:'<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
  appointments:'<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
  treatments:'<path d="M4.8 2.3A.3.3 0 1 0 5 2.8a.3.3 0 0 0-.2-.5M8 15a6 6 0 0 0 6-6V3a1 1 0 0 0-1-1M8 15a6 6 0 0 1-6-6V3a1 1 0 0 1 1-1M8 15v1a6 6 0 0 0 6 6h1a5 5 0 0 0 5-5"/>',
  journey:'<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M8 9h8M8 13h5"/>',
  campaigns:'<path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/>',
  inventory:'<path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5M12 22V12"/>',
  devices:'<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><path d="M9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2"/>',
  finance:'<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>',
  reports:'<path d="M3 3v18h18"/><path d="M18 17V9M13 17V5M8 17v-3"/>',
  settings:'<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/>',
  consultation:'<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
  laser:'<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
  botox:'<path d="M9 11.2 7 22M12 2 8 11l4 2 4-9-4 2ZM17 12l-3 10"/>',
  filler:'<path d="M12 3v18M3 12h18M5.6 5.6l12.8 12.8M18.4 5.6L5.6 18.4"/>',
  facial:'<circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>',
  followup:'<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8M21 3v5h-5M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16M3 21v-5h5"/>',
  pin:'<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
  chip:'<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><path d="M9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2"/>',
  walkin:'<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M19 8v6M22 11h-6"/>',
  emergency:'<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
  reschedule:'<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8M21 3v5h-5M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16M3 21v-5h5"/>',
  cancel:'<circle cx="12" cy="12" r="10"/><path d="m15 9-6 6M9 9l6 6"/>',
  print:'<path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6z"/>',
  consent:'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 15l2 2 4-4"/>',
  allergy:'<path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><path d="M12 9v4M12 17h.01"/>',
  payment:'<rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/>',
  form:'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M9 13h6M9 17h4"/>',
  noshow:'<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
  incomplete:'<path d="M13 2 3 14h9l-1 8 10-12h-9l1-8z"/>',
};
const svg=(n,w=20)=>`<svg width="${w}" height="${w}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${icons[n]}</svg>`;

/* داده‌ها */
const navItems=[
  {id:'dashboard',label:'داشبورد'},{id:'patients',label:'بیماران'},
  {id:'appointments',label:'نوبت‌ها',badge:3,active:true},{id:'treatments',label:'درمان‌ها'},
  {id:'journey',label:'سفر بیمار'},{id:'campaigns',label:'کمپین‌ها'},
  {id:'inventory',label:'انبار',badge:2},{id:'devices',label:'دستگاه‌ها'},
  {id:'finance',label:'مالی'},{id:'reports',label:'گزارش‌ها'},{id:'settings',label:'تنظیمات'},
];
const alerts=[
  {type:'amber',icon:'allergy',t:'هشدار حساسیت',d:'حساسیت به لیدوکائین — تست پوستی قبل از درمان لازم است'},
  {type:'red',icon:'payment',t:'پرداخت معوق',d:'۲۴ میلیون تومان بدهی — فاکتور INV-2891'},
  {type:'blue',icon:'form',t:'فرم رضایت ناقص',d:'فرم رضایت بوتاکس هنوز امضا نشده'},
  {type:'amber',icon:'noshow',t:'سابقه عدم‌حضور',d:'۲ عدم‌حضور در ۶ ماه گذشته — بیعانه لازم است'},
  {type:'gray',icon:'incomplete',t:'درمان ناتمام',d:'دوره لیزر — ۲ از ۶ جلسه انجام شده'},
];
const types=[
  {icon:'consultation',label:'مشاوره'},{icon:'laser',label:'لیزر'},
  {icon:'botox',label:'بوتاکس',active:true},{icon:'filler',label:'فیلر'},
  {icon:'facial',label:'فیشیال'},{icon:'followup',label:'پیگیری'},
];
const doctors=[
  {init:'ج‌م',name:'دکتر جیمز میچل',sub:'جراحی زیبایی',sel:'sel-blue',active:true},
  {init:'ا‌پ',name:'دکتر النا پارک',sub:'پوست',sel:'sel-blue'},
  {init:'س‌ت',name:'دکتر ساموئل تورس',sub:'لیزردرمانی',sel:'sel-blue',busy:true},
];
const rooms=[
  {icon:'pin',name:'سوئیت A',sub:'درمان',sel:'sel-green',active:true},
  {icon:'pin',name:'سوئیت B',sub:'مشاوره',sel:'sel-green'},
  {icon:'pin',name:'اتاق لیزر',sub:'لیزر',sel:'sel-green',busy:true},
];
const devices=[
  {icon:'chip',name:'سینوژر الیت+',sub:'لیزر',sel:'sel-purple',active:true},
  {icon:'chip',name:'ترماژ FLX',sub:'دستگاه RF',sel:'sel-purple'},
  {icon:'chip',name:'هایدرافیشیال MD',sub:'فیشیال',sel:'sel-purple',busy:true},
];
const treatChips=['بوتاکس — پیشانی ۲۰ واحد','فیلر لب ۰.۵ میلی‌لیتر','فیلر زیر چشم','لیزر کل صورت','هایدرافیشیال کلاسیک','پیلینگ شیمیایی'];
const treatActive=0;
const slots=[
  {t:'۰۹:۰۰',s:'booked'},{t:'۰۹:۳۰',s:'booked'},{t:'۱۰:۰۰',s:'selected'},
  {t:'۱۰:۳۰',s:'free'},{t:'۱۱:۰۰',s:'free'},{t:'۱۱:۳۰',s:'booked'},
  {t:'۱۳:۰۰',s:'free'},{t:'۱۳:۳۰',s:'free'},{t:'۱۴:۰۰',s:'booked'},
  {t:'۱۴:۳۰',s:'free'},{t:'۱۵:۰۰',s:'free'},{t:'۱۵:۳۰',s:'free'},
  {t:'۱۶:۰۰',s:'free'},{t:'۱۶:۳۰',s:'free'},{t:'۱۷:۰۰',s:'free'},
];
// تقویم تیر ۱۴۰۴: روز اول = یکشنبه، ۳۱ روز، روز ۳۱ انتخاب‌شده
const calBusy=[3,9,16,23,30];
const weekHead=['ش','ی','د','س','چ','پ','ج'];
const calFirstDayCol=1; // یکشنبه (ستون دوم، ایندکس ۱)
const calDays=31;

const docSched=[
  {init:'ج‌م',name:'جیمز میچل',blocks:[
    {span:1,type:'booked',label:'ماریا ک. — بوتاکس'},{span:1,type:'free',label:'آزاد'},
    {span:1,type:'sel',label:'سوفیا ا. ★'},{span:1,type:'empty'},
    {span:1,type:'booked',label:'جنیفر ل. — فیلر'},{span:1,type:'free',label:'آزاد'},
    {span:1,type:'empty'},{span:1,type:'booked',label:'پاتریشیا ن. — مشاوره'},
  ]},
  {init:'ا‌پ',name:'النا پارک',blocks:[
    {span:2,type:'free',label:'آزاد'},{span:2,type:'booked',label:'آلیس ب. — لیزر'},
    {span:2,type:'free',label:'آزاد'},{span:2,type:'booked',label:'ساندرا م. — فیشیال'},
  ]},
  {init:'س‌ت',name:'ساموئل تورس',blocks:[
    {span:3,type:'booked',label:'کارلوس ر. — RF'},{span:1,type:'empty'},
    {span:4,type:'booked',label:'کاملاً پُر'},
  ]},
];
const roomSched=[
  {name:'سوئیت A',blocks:[{span:2,type:'free',label:'آزاد'},{span:1,type:'sel',label:'سوفیا ا. ★'},{span:5,type:'free',label:'آزاد'}]},
  {name:'سوئیت B',blocks:[{span:3,type:'booked',label:'ماریا ک.'},{span:5,type:'free',label:'آزاد'}]},
  {name:'اتاق لیزر',blocks:[{span:8,type:'booked',label:'جلسات لیزر — تمام روز'}]},
];
const deviceAvail=[
  {name:'سینوژر الیت+',type:'دستگاه لیزر',status:'available',statusL:'در دسترس',used:'۴٬۲۰۰ / ۵۰٬۰۰۰ شات',pct:8,fill:'green',maint:'۱۹ مرداد ۱۴۰۴'},
  {name:'ترماژ FLX',type:'دستگاه RF',status:'available',statusL:'در دسترس',used:'۱٬۸۲۰ درمان',pct:36,fill:'blue',maint:'۱۲ شهریور ۱۴۰۴'},
  {name:'هایدرافیشیال MD',type:'دستگاه فیشیال',status:'inuse',statusL:'در حال استفاده',used:'۳٬۱۲۰ جلسه',pct:62,fill:'amber',maint:'۶ مرداد ۱۴۰۴'},
];
const recentAppts=[
  {dot:'green',name:'بوتاکس — پیشانی ۲۰ واحد',sub:'۲۸ خرداد ۱۴۰۴ · دکتر میچل',badge:'انجام‌شده',bcls:'li-done'},
  {dot:'green',name:'فیلر لب ۰.۵ میلی‌لیتر',sub:'۱۶ فروردین ۱۴۰۴ · دکتر میچل',badge:'انجام‌شده',bcls:'li-done'},
  {dot:'green',name:'هایدرافیشیال کلاسیک',sub:'۱ اسفند ۱۴۰۳ · دکتر پارک',badge:'انجام‌شده',bcls:'li-done'},
  {dot:'red',name:'مشاوره',sub:'۱۹ دی ۱۴۰۳ · دکتر میچل',badge:'عدم‌حضور',bcls:'li-noshow'},
  {dot:'green',name:'پیلینگ شیمیایی',sub:'۱۳ آبان ۱۴۰۳ · دکتر پارک',badge:'انجام‌شده',bcls:'li-done'},
];
const treatHistory=[
  {name:'بوتاکس ۲۰ واحد',sub:'۶ جلسه · آخرین: ۲۸ خرداد ۱۴۰۴',stars:5},
  {name:'فیلر لب',sub:'۳ جلسه · آخرین: ۱۶ فروردین ۱۴۰۴',stars:5},
  {name:'هایدرافیشیال',sub:'۴ جلسه · آخرین: ۱ اسفند ۱۴۰۳',stars:4},
  {name:'لیزر روسرفیسینگ',sub:'۲ از ۶ · آخرین: ۲۴ آبان ۱۴۰۳',stars:4},
  {name:'پیلینگ شیمیایی',sub:'۲ جلسه · آخرین: ۱۳ آبان ۱۴۰۳',stars:3},
];
const campHistory=[
  {init:'ای',name:'کمپین درخشش تابستان',sub:'۱۱ خرداد ۱۴۰۴',badge:'باز شد',bcls:'cst-opened'},
  {init:'پی',name:'ماه آگاهی بوتاکس',sub:'۲۵ اردیبهشت ۱۴۰۴',badge:'کلیک شد',bcls:'cst-clicked'},
  {init:'ای',name:'رویداد بهاره VIP',sub:'۱۲ فروردین ۱۴۰۴',badge:'حضور یافت',bcls:'cst-attended'},
  {init:'پی',name:'یادآوری دوره لیزر',sub:'۲۷ اسفند ۱۴۰۳',badge:'نادیده',bcls:'cst-ignored'},
  {init:'ز‌ت',name:'پیشنهاد تازگی زمستان',sub:'۲۱ دی ۱۴۰۳',badge:'رزرو شد',bcls:'cst-booked'},
];
const todaySchedule=[
  {time:'۰۹:۰۰',pt:'ماریا کیم',tag:'now',tagL:'اکنون',desc:'بوتاکس · دکتر میچل'},
  {time:'۱۰:۰۰',pt:'سوفیا اندرسن',tag:'new',tagL:'جدید',desc:'بوتاکس (در انتظار) · دکتر ...'},
  {time:'۱۱:۰۰',pt:'جنیفر لوئیس',desc:'فیلر لب · دکتر میچل'},
  {time:'۱۳:۰۰',pt:'آلیس بروکس',desc:'لیزر کل صورت · دکتر پارک'},
  {time:'۱۴:۳۰',pt:'پاتریشیا نوو',desc:'مشاوره · دکتر میچل'},
  {time:'۱۶:۰۰',pt:'ساندرا میلز',desc:'هایدرافیشیال · دکتر پارک'},
];
const weekAhead=[
  {day:'چهارشنبه ۱ مرداد',pct:53,fill:'amber',count:8},
  {day:'پنجشنبه ۲ مرداد',pct:80,fill:'red',count:12},
  {day:'جمعه ۳ مرداد',pct:33,fill:'green',count:5},
];
const quickActions=[
  {icon:'walkin',label:'ثبت مراجعه حضوری'},
  {icon:'emergency',label:'رزرو اورژانسی',emergency:true},
  {icon:'reschedule',label:'زمان‌بندی مجدد'},
  {icon:'cancel',label:'لغو نوبت'},
  {icon:'print',label:'چاپ نوبت'},
  {icon:'consent',label:'ارسال فرم رضایت'},
];

/* رندر */
document.getElementById('nav').innerHTML='<div class="nav-label">منوی اصلی</div>'+navItems.map(i=>`<a href="#" class="nav-item ${i.active?'active':''}" ${i.active?'aria-current="page"':''}>${svg(i.id)}<span>${i.label}</span>${i.badge?`<span class="nav-badge">${toFa(i.badge)}</span>`:''}</a>`).join('');

document.getElementById('alerts').innerHTML=alerts.map(a=>`<div class="alert-row ${a.type}"><span class="alert-ic">${svg(a.icon,18)}</span><div><div class="alert-t">${a.t}</div><div class="alert-d">${a.d}</div></div></div>`).join('');

document.getElementById('typeGrid').innerHTML=types.map(t=>`<div class="type-card ${t.active?'active':''}"><div class="ti">${svg(t.icon,22)}</div><div class="tn">${t.label}</div></div>`).join('');

function renderSelect(id,items){
  document.getElementById(id).innerHTML=items.map(d=>`
    <div class="sc-item ${d.sel} ${d.active?'active':''} ${d.busy?'busy':''}">
      <span class="sc-avatar">${d.init||svg(d.icon,16)}</span>
      <div class="sc-body"><div class="sc-name">${d.name}</div><div class="sc-sub">${d.sub}</div></div>
      ${d.busy?'<span class="sc-busy-tag">مشغول</span>':''}
    </div>`).join('');
}
renderSelect('doctorList',doctors);
renderSelect('roomList',rooms);
renderSelect('deviceList',devices);

document.getElementById('treatChips').innerHTML=treatChips.map((t,i)=>`<button class="tchip ${i===treatActive?'active':''}">${t}</button>`).join('');

document.getElementById('calHead').innerHTML=weekHead.map(d=>`<span>${d}</span>`).join('');
let calHtml='';
for(let i=0;i<calFirstDayCol;i++) calHtml+='<div class="cal-day empty"></div>';
for(let d=1;d<=calDays;d++){
  const busy=calBusy.includes(d), sel=d===31;
  calHtml+=`<div class="cal-day ${busy?'busy':''} ${sel?'selected':''}">${toFa(d)}</div>`;
}
document.getElementById('calGrid').innerHTML=calHtml;

document.getElementById('slots').innerHTML=slots.map(s=>`<div class="slot ${s.s}">${s.t}</div>`).join('');

// اشغال پزشک
const timeLabels=['','۹','۱۰','۱۱','۱۲','۱۳','۱۴','۱۵','۱۶'];
document.getElementById('schedTimes').innerHTML=timeLabels.map((t,i)=>i===0?'<span class="corner"></span>':`<span>${t}</span>`).join('');
function renderSched(id,rows,withAvatar){
  document.getElementById(id).innerHTML=rows.map(r=>{
    let blocks='';
    r.blocks.forEach(b=>{
      if(b.type==='empty'){ blocks+=`<div class="blk blk-empty" style="grid-column:span ${b.span}"></div>`; }
      else blocks+=`<div class="blk blk-${b.type}" style="grid-column:span ${b.span}">${b.label}</div>`;
    });
    const name=withAvatar
      ? `<div class="sched-name"><span class="sa">${r.init}</span>${r.name}</div>`
      : `<div class="room-name">${svg('pin',14)}${r.name}</div>`;
    return `<div class="sched-row">${name}${blocks}</div>`;
  }).join('');
}
renderSched('doctorSched',docSched,true);
renderSched('roomSched',roomSched,false);

// دستگاه‌ها
document.getElementById('deviceAvail').innerHTML=deviceAvail.map(d=>`
  <div class="dev-item">
    <div class="dev-top"><div><div class="dev-name">${d.name}</div><div class="dev-type">${d.type}</div></div><span class="dev-status ${d.status}">${d.statusL}</span></div>
    <div class="dev-usage"><span class="l">ظرفیت مصرف</span><span class="v">${d.used}</span></div>
    <div class="dev-bar"><div class="dev-fill ${d.fill}" style="width:${d.pct}%"></div></div>
    <div class="dev-maint"><span class="l">سرویس بعدی</span><span class="v">${d.maint}</span></div>
  </div>`).join('');

// لیست‌ها
document.getElementById('recentAppts').innerHTML=recentAppts.map(r=>`<div class="li-row"><span class="li-dot ${r.dot}"></span><div class="li-body"><div class="li-name">${r.name}</div><div class="li-sub">${r.sub}</div></div><span class="li-badge ${r.bcls}">${r.badge}</span></div>`).join('');

function starStr(n){ let s=''; for(let i=0;i<5;i++) s+=i<n?'★':'<span class="empty">★</span>'; return s; }
document.getElementById('treatHistory').innerHTML=treatHistory.map(t=>`<div class="li-row"><div class="li-body"><div class="li-name">${t.name}</div><div class="li-sub">${t.sub}</div></div><span class="stars">${starStr(t.stars)}</span></div>`).join('');

document.getElementById('campHistory').innerHTML=campHistory.map(c=>`<div class="li-row"><span class="li-avatar">${c.init}</span><div class="li-body"><div class="li-name">${c.name}</div><div class="li-sub">${c.sub}</div></div><span class="li-c-badge ${c.bcls}">${c.badge}</span></div>`).join('');

// ستون راست
document.getElementById('todaySchedule').innerHTML=todaySchedule.map(s=>`
  <div class="sched-item ${s.tag||''}">
    <span class="sched-time">${s.time}</span>
    <div class="sched-info"><div class="sched-pt">${s.pt}${s.tag?`<span class="sched-tag ${s.tag}">${s.tagL}</span>`:''}</div><div class="sched-desc">${s.desc}</div></div>
  </div>`).join('');

document.getElementById('weekAhead').innerHTML=weekAhead.map(w=>`
  <div class="week-row"><span class="week-day">${w.day}</span><div class="week-bar"><div class="week-fill ${w.fill}" style="width:${w.pct}%"></div></div><span class="week-count">${toFa(w.count)}</span></div>`).join('');

document.getElementById('quickActions').innerHTML=quickActions.map(q=>`<a href="#" class="qa-item ${q.emergency?'emergency':''}"><span class="qi">${svg(q.icon,18)}</span>${q.label}</a>`).join('');

/* تعامل‌ها */
function makeSelectable(containerId,itemSel){
  const c=document.getElementById(containerId);
  c.addEventListener('click',e=>{
    const item=e.target.closest(itemSel);
    if(!item||item.classList.contains('busy'))return;
    c.querySelectorAll(itemSel).forEach(x=>x.classList.remove('active'));
    item.classList.add('active');
  });
}
makeSelectable('typeGrid','.type-card');
makeSelectable('doctorList','.sc-item');
makeSelectable('roomList','.sc-item');
makeSelectable('deviceList','.sc-item');
makeSelectable('treatChips','.tchip');

// تقویم
document.getElementById('calGrid').addEventListener('click',e=>{
  const d=e.target.closest('.cal-day');
  if(!d||d.classList.contains('empty')||d.classList.contains('busy'))return;
  document.querySelectorAll('.cal-day').forEach(x=>x.classList.remove('selected'));
  d.classList.add('selected');
});
// بازه‌ها
document.getElementById('slots').addEventListener('click',e=>{
  const s=e.target.closest('.slot');
  if(!s||s.classList.contains('booked'))return;
  document.querySelectorAll('.slot').forEach(x=>x.classList.remove('selected'));
  s.classList.add('selected');
});

// دارک‌مود
const html=document.documentElement;
const themeBtn=document.getElementById('themeBtn');
const sun=themeBtn.querySelector('.ic-sun'), moon=themeBtn.querySelector('.ic-moon');
let theme='light';
function applyTheme(t){ theme=t; html.setAttribute('data-theme',t); sun.style.display=t==='dark'?'none':'block'; moon.style.display=t==='dark'?'block':'none'; }
applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light');
themeBtn.addEventListener('click',()=>applyTheme(theme==='light'?'dark':'light'));

// منوی موبایل
const menuToggle=document.getElementById('menuToggle'), overlay=document.getElementById('overlay');
menuToggle.addEventListener('click',()=>html.classList.toggle('nav-open'));
overlay.addEventListener('click',()=>html.classList.remove('nav-open'));
document.querySelectorAll('.nav-item').forEach(n=>n.addEventListener('click',()=>html.classList.remove('nav-open')));