
const stats=[
  {title:'درآمد امروز',icon:'dollar',color:'green',val:'۱۷۵ م ت',sub:'۱۲٪+ نسبت به دیروز',cls:'up'},
  {title:'نوبت‌ها',icon:'appointments',color:'brand',val:'۲۲',sub:'۲ انجام‌شده'},
  {title:'بازه‌های آزاد',icon:'clock',color:'teal',val:'۶',sub:'بعدی ساعت ۱۲:۳۰'},
  {title:'لغوشده',icon:'xcircle',color:'red',val:'۱',sub:'۲ مورد امروز صبح'},
  {title:'عدم‌حضور',icon:'warn',color:'orange',val:'۱',sub:'توماس گرنت',cls:'warn'},
  {title:'در انتظار',icon:'hourglass',color:'amber',val:'۳',sub:'تقریباً ۱۵ تا ۵۵ دقیقه'},
];
const doctors=[
  {init:'س‌چ',name:'دکتر سارا چن',spec:'لیزر و بازسازی پوست',count:6,color:'#2563eb'},
  {init:'ج‌م',name:'دکتر جیمز مالک',spec:'تزریقات و فیلر',count:5,color:'#4f46e5'},
  {init:'ا‌ت',name:'دکتر اِما تورس',spec:'پوست و آبرسانی',count:5,color:'#059669'},
  {init:'م‌پ',name:'دکتر مایکل پارک',spec:'RF و سفت‌کردن',count:6,color:'#ea580c'},
];
// ساعت‌ها: ۷ صبح تا ۸ شب
const startHour=7, endHour=20;
// نوبت‌ها: col=ایندکس پزشک، start=ساعت اعشاری، dur=ساعت
const appts=[
  {col:0,start:8,dur:1,init:'م',name:'میا جانسون',treat:'هایدرافیشیال دلوکس',room:'اتاق ۲ · هایدرافیشیال MD',c:'c-green',dot:'#059669'},
  {col:0,start:9.15,dur:.55,init:'آ',name:'آنا رودریگز',c:'c-purple',dot:'#7c3aed'},
  {col:0,start:10.5,dur:1.5,init:'ا',name:'اِما دیویس',treat:'لیزر روسرفیسینگ فرکسل',room:'سوئیت لیزر · فرکسل ۱۵۵۰',c:'c-blue',dot:'#2563eb',vip:true,selected:true},
  {col:0,start:13,dur:1,init:'س',name:'سوفی ویلیامز',treat:'پیلینگ شیمیایی VI',room:'اتاق ۳',c:'c-green',dot:'#059669'},
  {col:0,start:15,dur:.55,init:'ر',name:'راشل کیم',c:'c-amber',dot:'#f59e0b'},
  {col:0,start:16,dur:1,init:'ل',name:'لورا چن',treat:'میکرونیدلینگ RF',room:'اتاق ۴ · Secret RF',c:'c-green',dot:'#059669'},

  {col:1,start:8.5,dur:1.2,init:'ج',name:'جیمز ترنر',treat:'درمان مو PRP',room:'اتاق ۳',c:'c-green',dot:'#059669'},
  {col:1,start:10.2,dur:1.3,init:'ا',name:'ایزابلا براون',treat:'کمبو بوتاکس + فیلر',room:'اتاق ۲',c:'c-purple',dot:'#7c3aed',vip:true},
  {col:1,start:12,dur:.55,init:'م',name:'مارک لی',c:'c-blue',dot:'#2563eb'},
  {col:1,start:14,dur:1.4,init:'ا',name:'اولیویا پارک',treat:'لیزر موهای زائد',room:'سوئیت لیزر · فرکسل ۱۵۵۰',c:'c-green',dot:'#059669',confirm:true},
  {col:1,start:16.3,dur:.7,init:'ک',name:'کریس اوانز',treat:'تزریق کایبلا',c:'c-red',dot:'#dc2626'},

  {col:2,start:9.2,dur:1.5,init:'ن',name:'ناتالی اسکات',treat:'ترماژ FLX پلاتینیوم',room:'اتاق ۲ · هایدرافیشیال MD',c:'c-green',dot:'#059669',confirm:true},
  {col:2,start:11.2,dur:.55,init:'د',name:'دایانا رید',c:'c-blue',dot:'#2563eb'},
  {col:2,start:12.5,dur:1.5,init:'و',name:'ویکتوریا هال',treat:'اولترافی کل صورت',room:'اتاق ۴',c:'c-purple',dot:'#7c3aed',vip:true},
  {col:2,start:14.7,dur:.9,init:'آ',name:'آلیس کوپر',treat:'میکرونیدلینگ + PRP',room:'اتاق ۳',c:'c-amber',dot:'#f59e0b'},
  {col:2,start:16,dur:1,init:'ل',name:'لی‌لی اوانز',treat:'فیلر لب و گونه',room:'اتاق ۱',c:'c-green',dot:'#059669'},

  {col:3,start:8,dur:.55,init:'ه',name:'هنری ویلسون',c:'c-blue',dot:'#2563eb'},
  {col:3,start:9.2,dur:1.5,init:'گ',name:'گریس تیلور',treat:'ترماژ FLX صورت',room:'اتاق ۴ · ترماژ FLX',c:'c-purple',dot:'#7c3aed',vip:true},
  {col:3,start:11.2,dur:1,init:'ر',name:'رایان جانسون',treat:'پیلینگ شیمیایی TCA',room:'اتاق ۳',c:'c-green',dot:'#059669'},
  {col:3,start:13.5,dur:1.2,init:'آ',name:'آوا مارتینز',treat:'درمان Secret RF',room:'اتاق ۲ · Secret RF',c:'c-green',dot:'#059669',confirm:true},
  {col:3,start:15.4,dur:.7,init:'ت',name:'توماس گرنت',treat:'کایبلا + بوتاکس',c:'c-red',dot:'#dc2626'},
  {col:3,start:16.3,dur:.7,init:'ک',name:'کلر بنت',treat:'بوتاکس کل صورت',c:'c-amber',dot:'#f59e0b'},
];
const nowTime=15.6; // خط زمان فعلی

const freeSlots=[
  {time:'۱۲:۳۰',doc:'دکتر سارا چن · اتاق ۱',pct:'۹۵٪'},
  {time:'۱۳:۰۰',doc:'دکتر جیمز مالک · اتاق ۲',pct:'۸۸٪'},
  {time:'۱۵:۳۰',doc:'دکتر اِما تورس · اتاق ۳',pct:'۸۲٪'},
];
const resources=[
  {name:'اتاق ۱',status:'free',label:'آزاد'},
  {name:'اتاق ۲',status:'inuse',label:'در حال استفاده'},
  {name:'اتاق ۳',status:'inuse',label:'در حال استفاده'},
  {name:'سوئیت لیزر',status:'maint',label:'تعمیرات'},
  {name:'اتاق ۴',status:'free',label:'آزاد'},
];
const devices=[
  {name:'فرکسل ۱۵۵۰',badge:'active',badgeL:'فعال',sub:'در حال استفاده — دکتر سارا چن',shots:'۲٬۳۴۰ / ۵٬۰۰۰',pct:47},
  {name:'هایدرافیشیال MD',badge:'active',badgeL:'فعال',sub:'در حال استفاده — دکتر اِما تورس'},
  {name:'ترماژ FLX',badge:'ready',badgeL:'آماده',sub:'سرویس بعدی: ۶ بهمن'},
  {name:'Secret RF',badge:'ready',badgeL:'آماده',sub:'آماده — کاملاً استریل شده'},
];
const waitList=[
  {init:'م‌و',name:'مارکوس وب',prio:'high',prioL:'زیاد',sub:'ترمیم بوتاکس · حدود ۱۵ دقیقه انتظار'},
  {init:'ج‌پ',name:'جوانا پرایس',prio:'med',prioL:'متوسط',sub:'هایدرافیشیال · حدود ۳۵ دقیقه انتظار'},
  {init:'د‌ک',name:'دیوید کانگ',prio:'low',prioL:'کم',sub:'مشاوره · حدود ۵۵ دقیقه انتظار'},
];


document.getElementById('statGrid').innerHTML=stats.map(s=>`
  <div class="stat-card">
    <div class="stat-top"><span class="stat-title">${s.title}</span><span class="stat-ic" style="background:var(--${s.color}-soft);color:var(--${s.color})">${svg(s.icon,15)}</span></div>
    <div class="stat-val">${s.val}</div>
    <div class="stat-sub ${s.cls||''}">${s.sub}</div>
  </div>`).join('');

document.getElementById('docHeader').innerHTML='<div class="dh-time">زمان</div>'+doctors.map(d=>`
  <div class="dh-doc">
    <span class="dh-avatar" style="background:${d.color}">${d.init}</span>
    <div class="dh-info"><div class="dh-name">${d.name}</div><div class="dh-spec">${d.spec}</div></div>
    <span class="dh-count">${toFa(d.count)}</span>
  </div>`).join('');

// شبکه
const hours=endHour-startHour;
let timeHtml='<div class="time-col">';
for(let h=startHour;h<endHour;h++){
  const label=h<12?`${toFa(h)}:۰۰ ص`:h===12?'۱۲:۰۰ ظ':`${toFa(h-12)}:۰۰ ع`;
  timeHtml+=`<div class="time-cell"><span>${label}</span></div>`;
}
timeHtml+='</div>';

let colsHtml='';
for(let c=0;c<4;c++){
  let lines='';
  for(let h=0;h<hours;h++) lines+='<div class="hour-line"></div>';
  const items=appts.filter(a=>a.col===c).map((a,i)=>{
    const top=(a.start-startHour)*80;
    const height=a.dur*80-6;
    return `<div class="appt ${a.c} ${a.selected?'selected':''}" style="top:${top}px;height:${height}px" data-i="${c}-${i}">
      <div class="appt-top"><span class="appt-dot" style="background:${a.dot}">${a.init}</span><span class="appt-name">${a.name}</span>${a.vip&&a.dur<1?'<span class="appt-tag tag-vip" style="margin:0">VIP</span>':''}</div>
      ${a.treat?`<div class="appt-treat">${a.treat}</div>`:''}
      ${a.room?`<div class="appt-room">${a.room}</div>`:''}
      ${a.confirm?'<span class="appt-tag tag-confirm">تأییدشده</span>':''}
      ${a.vip&&a.dur>=1?'<span class="appt-tag tag-vip">VIP</span>':''}
    </div>`;
  }).join('');
  const nowLine=`<div class="now-line" style="top:${(nowTime-startHour)*80}px"></div>`;
  colsHtml+=`<div class="doc-col">${lines}${items}${nowLine}</div>`;
}
document.getElementById('gridWrap').innerHTML=timeHtml+colsHtml;

document.getElementById('freeSlots').innerHTML=freeSlots.map(s=>`
  <div class="slot-row">
    <span class="slot-ic">${svg('clock',17)}</span>
    <div class="slot-body"><div class="slot-time">${s.time}</div><div class="slot-doc">${s.doc}</div></div>
    <span class="slot-pct">${s.pct}</span>
  </div>`).join('');

document.getElementById('resources').innerHTML=resources.map(r=>`
  <div class="res-row"><span class="res-dot ${r.status}"></span><span class="res-name">${r.name}</span><span class="res-status ${r.status}">${r.label}</span></div>`).join('');

document.getElementById('devices').innerHTML=devices.map(d=>`
  <div class="dev-card">
    <div class="dev-top"><span class="dev-name">${d.name}</span><span class="dev-badge ${d.badge}">${d.badgeL}</span></div>
    <div class="dev-sub">${d.sub}</div>
    ${d.shots?`<div class="dev-shots"><span class="l">شات باقی‌مانده</span><span class="v">${d.shots}</span></div><div class="dev-bar"><div class="dev-fill" style="width:${d.pct}%"></div></div>`:''}
  </div>`).join('');

document.getElementById('waitList').innerHTML=waitList.map(w=>`
  <div class="wait-row">
    <span class="wait-avatar">${w.init}</span>
    <div class="wait-body">
      <div class="wait-name-row"><span class="wait-name">${w.name}</span><span class="prio ${w.prio}">${w.prioL}</span></div>
      <div class="wait-sub">${w.sub}</div>
    </div>
    <button class="wait-btn">زمان‌بندی →</button>
  </div>`).join('');

/* ═══ تعامل‌ها ═══ */
document.getElementById('gridWrap').addEventListener('click',e=>{
  const a=e.target.closest('.appt'); if(!a)return;
  document.querySelectorAll('.appt').forEach(x=>x.classList.remove('selected'));
  a.classList.add('selected');
});