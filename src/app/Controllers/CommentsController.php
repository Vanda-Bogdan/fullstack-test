<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommentModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class CommentsController extends BaseController
{
    public function index()
    {
        $allowedColumns = ['id', 'date'];
        $allowedDirections = ['asc', 'desc'];

        $sort = $this->request->getGet('sort') ?? session()->get('comments_sort') ?? 'date';
        $dir  = $this->request->getGet('dir')  ?? session()->get('comments_dir')  ?? 'desc';

        if (! in_array($sort, $allowedColumns, true)) {
            $sort = 'date';
        }
        if (! in_array($dir, $allowedDirections, true)) {
            $dir = 'desc';
        }

        session()->set('comments_sort', $sort);
        session()->set('comments_dir', $dir);

        $model = new CommentModel();

        $comments = $model
            ->select('comments.*, users.email AS user_email')
            ->join('users', 'users.id = comments.user_id')
            ->orderBy('comments.' . $sort, strtoupper($dir))
            ->paginate(3);

        $model->pager->setPath('/');

        return view('comments/index', [
            'comments' => $comments,
            'pager'    => $model->pager,
            'sort'     => $sort,
            'dir'      => $dir,
        ]);
    }

    public function listAjax()
    {
        $allowedColumns = ['id', 'date'];
        $allowedDirections = ['asc', 'desc'];

        $sort = $this->request->getGet('sort') ?? session()->get('comments_sort') ?? 'date';
        $dir  = $this->request->getGet('dir')  ?? session()->get('comments_dir')  ?? 'desc';

        if (! in_array($sort, $allowedColumns, true)) {
            $sort = 'date';
        }
        if (! in_array($dir, $allowedDirections, true)) {
            $dir = 'desc';
        }

        session()->set('comments_sort', $sort);
        session()->set('comments_dir', $dir);

        $model = new CommentModel();

        $comments = $model
            ->select('comments.*, users.email AS user_email')
            ->join('users', 'users.id = comments.user_id')
            ->orderBy('comments.' . $sort, strtoupper($dir))
            ->paginate(3);

        $model->pager->setPath('/');

        return $this->response->setJSON([
            'list'  => view('comments/list', [
                'comments' => $comments,
                'pager' => $model->pager
            ]),
        ]);
    }

    public function store()
    {
        if (! session()->get('user_id')) {
            return redirect()
                ->to('/login')
                ->with('error', 'Войдите, чтобы оставить комментарий.');
        }

        $rules = [
            'text' => 'required|min_length[3]|max_length[200]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $this->validator->getErrors());
        }

        $model = new CommentModel();
        $model->insert([
            'user_id' => session()->get('user_id'),
            'text'    => $this->request->getPost('text'),
            'date'    => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->to('/')
            ->with('success', 'Комментарий добавлен.');
    }

    public function storeAjax()
    {
        if (! session()->get('user_id')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['error' => 'Войдите, чтобы оставить комментарий.']);
        }

        $rules = [
            'text' => 'required|min_length[3]|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['error' => $this->validator->getErrors()]);
        }

        $model = new CommentModel();
        $model->insert([
            'user_id' => session()->get('user_id'),
            'text'    => $this->request->getPost('text'),
            'date'    => date('Y-m-d H:i:s'),
        ]);

        $comment = $model
            ->select('comments.*, users.email AS user_email')
            ->join('users', 'users.id = comments.user_id')
            ->find($model->getInsertID());

        return $this->response->setJSON([
            'status'  => 'ok',
            'comment' => $comment,
            'current_user_id' => session()->get('user_id'),
        ]);
    }

    public function deleteAjax($id = null)
    {
        if (! session()->get('user_id')) {
            return $this->response->setStatusCode(401)
                ->setJSON(['error' => 'Войдите, чтобы удалить комментарий.']);
        }

        $model = new CommentModel();
        $comment = $model->find($id);

        if (! $comment) {
            return $this->response->setStatusCode(404)
                ->setJSON(['errors' => 'Комментарий не найден.']);
        }

        if ((int) $comment['user_id'] !== (int) session()->get('user_id')) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON(['error' => 'Вы можете удалять только свои комментарии.']);
        }

        $model->delete($id);

        return $this->response->setJSON(['status' => 'ok']);
    }
}
