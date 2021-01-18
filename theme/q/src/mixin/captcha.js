const captcha = {
  data () {
    return {
      cf_captcha : null,
      cf_captcha_text : null,
    }
  },
  methods: {
    captcha(){
      if(this.cf_captcha == 'kcaptcha' && this.$store.state.isLogin == false){
        var canvas = document.createElement("canvas");
        var input = document.createElement("input");
        input.className = "border py-1 px-2";
        input.style.width = "100px";
        input.name="captcha_key";
        input.id="captcha_key";
        canvas.id = "Kcaptcha";
        canvas.width = 100;
        canvas.height = 50;
        var ctx = canvas.getContext("2d");
        ctx.font = "25px Georgia";
        ctx.strokeText(this.cf_captcha_text, 5 , 30);
        for(var i=0;i<20;i++){
          ctx.strokeStyle ="#" +  Math.floor(Math.random()*0xFFFFFF).toString(16);
          ctx.beginPath();
          ctx.arc(Math.floor(Math.random()*(100)+1) , Math.floor(Math.random()*(80)+1), Math.floor(Math.random()*(100)+1), 0 ,2*Math.PI);
          ctx.stroke();
        }
        const num = 20;
        const radius = 2;
        const max = 100;
        for (i = 0; i <=num; i++) {
          ctx.strokeStyle ="#" +  Math.floor(Math.random()*0xFFFFFF).toString(16);
          ctx.beginPath();
          var rand_x = Math.random(i) * max;
          var rand_y = Math.random(i) * max;
          ctx.arc(rand_x, rand_y, radius, 0, 2*Math.PI);
          ctx.fill();
          ctx.closePath();
        }
        this.$nextTick(() => {
          this.$refs.captcha.appendChild(canvas);  
          this.$refs.captcha.appendChild(input);  
        });
      }
    },
  },
};
export default captcha;
