    <?php
    $js_array = ['js/member.js'];
    $g_title = '약관';
    $menu_code = 'member';

    include 'inc/header.php';
    ?>

    <main class="p-5 border rounded-5">
      <h1 class="text-center">회원 약관 및 개인정보 취급방침 동의</h1>
      <h4>회원 약관</h4>
      <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum nihil provident officiis corporis sint ducimus esse, hic maxime nam amet in, repellendus soluta ab quae totam labore error. Ad repellendus suscipit repudiandae placeat debitis eveniet cupiditate. Provident ratione, sunt rem consequatur, asperiores dolore quaerat et labore repellendus incidunt non dicta corporis voluptatem ipsam quisquam cum facilis enim magni doloribus, aspernatur ut nemo eveniet! Perferendis nemo sequi quam, autem hic necessitatibus animi adipisci alias aut, porro saepe nam perspiciatis aliquid? Voluptas mollitia impedit, culpa aperiam blanditiis vel minus numquam architecto fugiat sapiente inventore, quae quidem voluptatibus nemo aliquam, reprehenderit nostrum! Voluptas, qui consequuntur laborum cupiditate reiciendis excepturi fugiat at? Quod asperiores est minima cumque eaque adipisci accusantium nisi unde voluptates! Assumenda error esse voluptates obcaecati facere quidem iure! Error suscipit quia unde sint eaque dignissimos qui, amet libero accusamus possimus soluta, pariatur, reiciendis fugiat. Magnam laboriosam deleniti placeat odit libero nostrum eveniet quos obcaecati saepe incidunt voluptatem veritatis rem, expedita voluptatibus maxime, excepturi quas consequuntur nobis qui. Optio harum blanditiis at tempora placeat dolore deleniti molestiae fugit consequuntur natus laborum ut totam nemo nobis, eum necessitatibus quis nostrum consectetur doloremque ad architecto ea laboriosam non corrupti. At porro exercitationem aperiam ut quas omnis fugiat accusamus, culpa eveniet, similique iste tenetur totam, sint hic architecto deserunt beatae enim quis nostrum cupiditate non perferendis. Error, numquam. Facilis harum dolorum, inventore minima quia odit aliquid nisi! Nobis, inventore consequuntur eos unde ad quo temporibus perspiciatis excepturi recusandae consequatur velit ipsum amet nam ducimus distinctio sequi repudiandae maxime minus dolorem! Totam, ad. Exercitationem ipsa, deserunt eaque reprehenderit culpa repellendus assumenda iure. Doloremque quaerat rem dolor blanditiis unde corporis ipsum. A nam eligendi distinctio eaque dolore omnis at? Ea ducimus odit necessitatibus maiores eveniet veritatis dolor dolores, vero, recusandae perferendis iusto nulla? Tempore doloribus voluptas quasi?
      </textarea>

      <div class="form-check mt-2">
        <!-- for와 id 맞춰야 글씨 클릭해도 체크됨 -->
        <input class="form-check-input" type="checkbox" value="" id="chk_member1">
        <label class="form-check-label" for="chk_member1">
          위 약관에 동의하시겠습니까?
        </label>
      </div>

      <h4 class="mt-3">개인정보 취급방침</h4>
      <textarea name="" id="" cols="30" rows="10" class="form-control">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla ipsum ab cupiditate nostrum eos architecto pariatur optio, dolore cumque quae tempore perferendis illum asperiores nisi tenetur ad fugit perspiciatis aliquam magnam velit expedita? Quos ipsa quisquam eum vitae odit ab laudantium rem! In repellat assumenda corrupti doloremque non iusto hic fugit sint, beatae possimus animi a. Tempora nostrum similique animi fugiat sit veritatis temporibus a, eum qui vitae error! Ea fugiat maiores quisquam assumenda iure eos, corrupti nulla, nam libero odio ex ratione. Eaque similique odit cum eos? Earum fuga, soluta doloremque maxime nisi minus provident perferendis corrupti quia fugiat ut doloribus molestias assumenda dolores. Necessitatibus, exercitationem non ratione aut molestiae temporibus dolore magnam, at eius aperiam quam a officia, minima mollitia quos repellat vel! Accusantium quo obcaecati, eius a dolorem optio? Vel deserunt ab a ullam non optio quas veritatis voluptatum architecto vero voluptates aliquid, animi quaerat omnis iste! Magni error obcaecati fuga enim libero, non aut, officia sunt eius consectetur, doloremque tenetur eveniet. Pariatur natus debitis dolorem culpa repellendus amet temporibus, exercitationem adipisci provident quaerat libero nulla facere eaque tenetur nostrum illo sed nisi quod ut iusto ab quia animi unde. Quidem minus cupiditate pariatur optio autem temporibus animi esse totam. Dignissimos quae hic, nemo maiores harum modi vero. Ex facilis saepe quasi natus consequatur assumenda mollitia est qui recusandae voluptatibus aperiam non, enim veniam ipsa maiores facere rerum fuga. Voluptatibus, sapiente similique eos id inventore possimus labore consequuntur cupiditate eius laboriosam velit necessitatibus repudiandae vero deleniti nobis? In, consequuntur excepturi id repellat et sapiente tempora amet ut officia repellendus architecto magni cupiditate quas facere quia vitae voluptates, eveniet voluptatibus sunt dolores modi quod rerum culpa! Sint, eveniet. Eligendi harum numquam magnam praesentium ratione doloremque aperiam non nihil alias, adipisci maxime delectus, atque odio. Culpa nulla beatae sunt.
      </textarea>

      <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" value="" id="chk_member2">
        <label class="form-check-label" for="chk_member2">
          위 개인정보 취급방침에 동의하시겠습니까?
        </label>
      </div>
      <div class="mt-4 d-flex justify-content-center gap-2">
        <button class="btn btn-primary w-50" id="btn_member">회원가입</button>
        <button class="btn btn-secondary w-50">가입취소</button>
      </div>

      <form method="post" name="stipluation_form" action="member_input.php">
        <input type="hidden" name="chk" value="0">
      </form>

    </main>
    </div>

    <?php include 'inc/footer.php'; ?>